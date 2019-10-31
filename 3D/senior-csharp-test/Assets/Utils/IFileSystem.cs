using System.IO;

public interface IFileSystem
{
    string[] GetFiles( string path );
    void     DeleteFile( string path );
    void     DeleteDir( string path, bool recursive = true );
    bool     FileExists( string path );
    bool     DirExists( string path );
    void     CreateFile( string path );
    void     CreateDir( string path );
    void     WriteText( string path, string text, FileMode fileMode = FileMode.Create, FileAccess fileAccess = FileAccess.Write, FileShare fileShare = FileShare.ReadWrite );
    void     Write( string path, byte[] bytes, FileMode fileMode = FileMode.Create, FileAccess fileAccess = FileAccess.Write, FileShare fileShare = FileShare.ReadWrite );
    string   ReadText( string path, FileMode fileMode = FileMode.Open, FileAccess fileAccess = FileAccess.Read, FileShare fileShare = FileShare.Read );
    byte[]   Read( string path, FileMode fileMode = FileMode.Open, FileAccess fileAccess = FileAccess.Read, FileShare fileShare = FileShare.Read );
}
