using System;
using System.Collections.Generic;

[ Serializable ]
public class FileCacheStorage : ICacheStorage
{
	private const float EXPIRING_TIME_DAYS = 60f;

	private readonly string _cachePath;
	private readonly IFileSystem _fileSystem;

	public FileCacheStorage( string path, IFileSystem fileSystem )
	{
		if( string.IsNullOrEmpty( path ) )
			throw new NullReferenceException( nameof( path ) );

		_cachePath = path;
		_fileSystem = fileSystem ?? throw new NullReferenceException( nameof( fileSystem ) );

		InitCache();
	}

	private void InitCache()
	{
		if( !_fileSystem.DirExists( _cachePath ) )
		{
			_fileSystem.CreateDir( _cachePath );
			return;
		}

		ClearExpiredCacheFiles();
	}

	private void ClearExpiredCacheFiles()
	{
		DateTime dateNow = DateTime.UtcNow;

		string[] filePaths = _fileSystem.GetFiles( _cachePath );

		foreach( string filePath in filePaths )
		{
			DateTime lastAccessDate;
			try
			{
				lastAccessDate = _fileSystem.GetFileLastAccessTime( filePath );
			}
			catch( Exception e )
			{
				Log.LogError( "Couldn't access file last access time at path = " + filePath + ".\n" + e );
				continue;
			}

			TimeSpan span = dateNow - lastAccessDate;

			if( span.TotalDays > EXPIRING_TIME_DAYS )
			{
				try
				{
					_fileSystem.DeleteFile( filePath );
				}
				catch( Exception e )
				{
					Log.LogError( "Fail to delete expired cache file at path : " + filePath + ".\n" + e );
				}
			}
		}
	}

	private void UpdateUseDate( string filePath )
	{
		_fileSystem.SetFileLastAccessTime( filePath );
	}

	public byte[] Get( string id )
	{
		byte[] result;
		try
		{
			result = _fileSystem.Read( _cachePath + "/" + id );
		}
		catch( Exception e )
		{
			Log.LogError( "Fail to get the entry for id  " + id + ".\n" + e );
			return null;
		}

		UpdateUseDate( id );

		return result;
	}

	public bool Add( string id, byte[] value )
	{
		if( string.IsNullOrEmpty( id ) )
		{
			Log.LogError( "Fail to add a new entry : id is null or empty" );
			return false;
		}

		if( value == null || value.Length == 0 )
		{
			Log.LogError( "Fail to add a new entry : byte array is null or empty" );
			return false;
		}

		string path = _cachePath + "/" + id;

		try
		{
			_fileSystem.Write( path, value );
		}
		catch( Exception e )
		{
			Log.LogError( "Fail to add a new entry : " + e );
			return false;
		}

		return true;
	}

	public bool Remove( string id )
	{
		string filePath = _cachePath + "/" + id;
		try
		{
			_fileSystem.DeleteFile( filePath );
		}
		catch( Exception e )
		{
			Log.LogError( "Fail to delete file at path : " + filePath + ".\n" + e );
			return false;
		}

		return true;
	}
}
