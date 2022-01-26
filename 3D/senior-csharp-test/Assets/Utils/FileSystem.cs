using System.IO;
using System.Text;

public class FileSystem : IFileSystem
{
	public void DeleteFile( string path )
	{
		if( FileExists( path ) )
			File.Delete( path );
	}

	public void DeleteDir( string path, bool recursive = true )
	{
		if( DirExists( path ) )
			Directory.Delete( path, recursive );
	}

	public bool FileExists( string path )
	{
		return File.Exists( path );
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

	public void CreateFile( string path )
	{
		if( !FileExists( path ) )
			File.Create( path );
	}

	public void Write( string path, byte[] bytes, FileMode fileMode = FileMode.Create, FileAccess fileAccess = FileAccess.Write, FileShare fileShare = FileShare.ReadWrite )
	{
		using( FileStream file = new FileStream( path, fileMode, fileAccess, fileShare ) )
			file.Write( bytes, 0, bytes.Length );
	}

	public void WriteText( string path, string text, FileMode fileMode = FileMode.Create, FileAccess fileAccess = FileAccess.Write, FileShare fileShare = FileShare.ReadWrite )
	{
		Write( path, Encoding.ASCII.GetBytes( text ), fileMode, fileAccess, fileShare );
	}

	public string ReadText( string path, FileMode fileMode = FileMode.Open, FileAccess fileAccess = FileAccess.Read, FileShare fileShare = FileShare.Read )
	{
		using( FileStream file = new FileStream( path, fileMode, fileAccess, fileShare ) )
		{
			using( StreamReader sr = new StreamReader( file ) )
				return sr.ReadToEnd();
		}
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

	public string[] GetFiles( string path )
	{
		return Directory.GetFiles( path );
	}
}
