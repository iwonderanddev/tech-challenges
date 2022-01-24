using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;

[ Serializable ]
public class FileCacheStorage : ICacheStorage
{
	private const string ACTUAL_VERSION = "1.0";
	private const string DATE_FORMAT = "yyMMdd";
	private const float EXPIRING_TIME_DAYS = 60f;
	private readonly string _cachePath;
	private readonly Dictionary<string, FileCacheEntry> _cacheEntries = new Dictionary<string, FileCacheEntry>();
	private readonly string _fileName;
	private readonly IFileSystem _fileSystem;
	private readonly ISerializer _serializer;
	public List<FileCacheEntry> CacheEntries = new List<FileCacheEntry>();
	public string Version;

	[ Serializable ]
	public class FileCacheEntry : CacheEntry<string>
	{
		//FileCacheEntry stores the path of a file which contains the data, and not the data itself
		public FileCacheEntry( string id, string version, string pathData, string lastUseDate ) : base( id, version, pathData, lastUseDate )
		{
		}
	}

	public FileCacheStorage( string path, string fileName, IFileSystem fileSystem, ISerializer serializer )
	{
		_cachePath = path;
		_fileName = fileName;
		_fileSystem = fileSystem;
		_serializer = serializer;
		InitCache();
	}

	public byte[] Get( string id )
	{
		FileCacheEntry ce;

		if( !_cacheEntries.TryGetValue( id, out ce ) )
			return null;

		UpdateUseDate( id );
		return _fileSystem.Read( ce.Data );
	}

	public bool Has( string id )
	{
		if( _cacheEntries != null && _cacheEntries.ContainsKey( id ) )
			return true;

		return false;
	}

	public bool MatchesVersion( string id, string version )
	{
		try
		{
			if( _cacheEntries[ id ].Version == version )
				return true;
		}
		catch( Exception e )
		{
			Log.LogError( "Cache entry id = " + id + " not found : " + e.Message );
			return false;
		}

		return false;
	}

	public void Set( byte[] value, string id, string version = null )
	{
		string path = _cachePath + "/" + id;

		if( !Has( id ) || !_fileSystem.FileExists( path ) || !MatchesVersion( id, version ) )
			SaveFile( path, value );

		_cacheEntries[ id ] = new FileCacheEntry( id, version, path, DateTime.Now.ToString( DATE_FORMAT ) );
	}

	public void Delete( string id )
	{
		FileCacheEntry ce;

		if( !_cacheEntries.TryGetValue( id, out ce ) )
			return;

		try
		{
			DeleteFile( ce );
		}
		catch( Exception )
		{
			Log.LogError( "Fail to delete file : " + ce );
			return;
		}

		_cacheEntries.Remove( id );
	}

	public void DeleteAll()
	{
		_cacheEntries.Clear();
		CacheEntries.Clear();
		_fileSystem.DeleteDir( _cachePath );
	}

	public void SaveCacheStorageFile()
	{
		UpdateDataEntries();
		Version = ACTUAL_VERSION;
		CopyEntriesToSerializeList();
		string dataCacheTxt = _serializer.Serialize( this );

		if( !_fileSystem.DirExists( _cachePath ) )
			return;

		if( _fileSystem.FileExists( _cachePath + "/" + _fileName ) )
			_fileSystem.DeleteFile( _cachePath + "/" + _fileName );

		_fileSystem.Write( _cachePath + "/" + _fileName, Encoding.UTF8.GetBytes( dataCacheTxt ) );
	}

	private void UpdateUseDate( string id )
	{
		if( _cacheEntries.ContainsKey( id ) )
			_cacheEntries[ id ].LastUseDate = DateTime.Now.ToString( DATE_FORMAT );
	}

	private DateTime GetEntryLastUseDate( FileCacheEntry entry )
	{
		return DateTime.ParseExact( entry.LastUseDate, DATE_FORMAT, null );
	}

	private void SaveFile( string path, byte[] value )
	{
		if( !_fileSystem.DirExists( _cachePath ) )
			_fileSystem.CreateDir( _cachePath );

		_fileSystem.Write( path, value );
	}

	private void InitCache()
	{
		if( !_fileSystem.DirExists( _cachePath ) )
		{
			_fileSystem.CreateDir( _cachePath );
			return;
		}

		if( !_fileSystem.FileExists( _cachePath + "/" + _fileName ) )
			return;

		if( !TryLoadCacheEntries() )
			DeleteAll();

		CheckCacheVersion();
		ClearExpiredEntries();
	}

	private void CheckCacheVersion()
	{
		if( Version != ACTUAL_VERSION )
			DeleteAll();
	}

	private void ClearExpiredEntries()
	{
		List<FileCacheEntry> expiredEntries = GetExpiredEntries();

		foreach( FileCacheEntry t in expiredEntries )
			Delete( t.Id );
	}

	private List<FileCacheEntry> GetExpiredEntries()
	{
		DateTime dateNow = DateTime.Now;
		List<FileCacheEntry> expiredEntries = new List<FileCacheEntry>();

		foreach( KeyValuePair<string, FileCacheEntry> ce in _cacheEntries )
		{
			DateTime datetime = GetEntryLastUseDate( ce.Value );
			TimeSpan span = dateNow - datetime;

			if( span.TotalDays > EXPIRING_TIME_DAYS )
				expiredEntries.Add( ce.Value );
		}

		return expiredEntries;
	}

	private bool TryLoadCacheEntries()
	{
		string filePath = _cachePath + "/" + _fileName;

		if( !_fileSystem.FileExists( filePath ) )
			return false;

		try
		{
			LoadCacheEntriesFromFile( filePath );
			return true;
		}
		catch( Exception e )
		{
			Log.LogError( "Could not load cache entries from " + filePath + "!\n" + e.Message + "\n" + e.StackTrace );
		}

		return false;
	}

	/// <summary>
	/// Raises exception if json file is corrupted
	/// </summary>
	/// <param name="path">path to json file containtng serialized cache entries list</param>
	private void LoadCacheEntriesFromFile( string path )
	{
		string txt = _fileSystem.ReadText( path, FileMode.Open, FileAccess.Read, FileShare.ReadWrite );
		_serializer.Deserialize( txt, this );
		CopyDeserializedEntriesToDic();
	}

	private void CopyDeserializedEntriesToDic()
	{
		_cacheEntries.Clear();
		foreach( FileCacheEntry cacheEntry in CacheEntries )
			_cacheEntries.Add( cacheEntry.Id, cacheEntry );
	}

	private void CopyEntriesToSerializeList()
	{
		CacheEntries.Clear();

		foreach( KeyValuePair<string, FileCacheEntry> ce in _cacheEntries )
			CacheEntries.Add( ce.Value );
	}

	private void DeleteFile( FileCacheEntry ce )
	{
		if( ce.Data == null )
			return;

		string path = ce.Data;

		if( _fileSystem.FileExists( path ) )
			_fileSystem.DeleteFile( path );
	}

	private void UpdateDataEntries()
	{
		List<FileCacheEntry> oldEntries = _cacheEntries.Values.ToList();
		_cacheEntries.Clear();
		TryLoadCacheEntries();

		foreach( FileCacheEntry oldCe in oldEntries )
		{
			if( !_cacheEntries.ContainsKey( oldCe.Id ) )
				_cacheEntries.Add( oldCe.Id, oldCe );
			else
			{
				DateTime dateNewEntry = GetEntryLastUseDate( _cacheEntries[ oldCe.Id ] );
				DateTime dateOldEntry = GetEntryLastUseDate( oldCe );

				if( DateTime.Compare( dateNewEntry, dateOldEntry ) < 0 )
					_cacheEntries[ oldCe.Id ] = oldCe;
			}
		}
	}
}
