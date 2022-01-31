using System;
using System.IO;

public interface IFileSystem
{
	string[] GetFiles( string path );
	void DeleteFile( string path );
	bool DirExists( string path );
	void CreateDir( string path );
	void Write( string path, byte[] bytes, FileMode fileMode = FileMode.Create, FileAccess fileAccess = FileAccess.Write, FileShare fileShare = FileShare.ReadWrite );
	byte[] Read( string path, FileMode fileMode = FileMode.Open, FileAccess fileAccess = FileAccess.Read, FileShare fileShare = FileShare.Read );
	DateTime GetFileLastAccessTime( string filepath );
	void SetFileLastAccessTime( string filepath );
}
