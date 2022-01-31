using System;
using System.IO;
using System.Text;

public class FileSystem : IFileSystem
{
	public string[] GetFiles( string path )
	{
		return Directory.GetFiles( path );
	}

	public void DeleteFile( string path )
	{
		File.Delete( path );
	}

	public bool DirExists( string path )
	{
		return Directory.Exists( path );
	}

	public void CreateDir( string path )
	{
		if( !DirExists( path ) )
			Directory.CreateDirectory( path );
	}

	public void Write( string path, byte[] bytes, FileMode fileMode = FileMode.Create, FileAccess fileAccess = FileAccess.Write, FileShare fileShare = FileShare.ReadWrite )
	{
		using( FileStream file = new FileStream( path, fileMode, fileAccess, fileShare ) )
			file.Write( bytes, 0, bytes.Length );
	}

	public byte[] Read( string path, FileMode fileMode = FileMode.Open, FileAccess fileAccess = FileAccess.Read, FileShare fileShare = FileShare.Read )
	{
		using( FileStream file = new FileStream( path, fileMode, fileAccess, fileShare ) )
		{
			byte[] bytes = new byte[ file.Length ];
			int numBytesToRead = ( int )file.Length;
			int numBytesRead = 0;

			while( numBytesToRead > 0 )
			{
				int n = file.Read( bytes, numBytesRead, numBytesToRead );

				if( n == 0 )
					break;

				numBytesRead += n;
				numBytesToRead -= n;
			}

			return bytes;
		}
	}

	public DateTime GetFileLastAccessTime( string filepath )
	{
		return File.GetLastAccessTime( filepath );
	}

	public void SetFileLastAccessTime( string filepath )
	{
		File.SetLastAccessTime( filepath, DateTime.UtcNow );
	}
}
