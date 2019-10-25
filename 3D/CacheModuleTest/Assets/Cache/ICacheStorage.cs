public interface ICacheStorage
{
    void   Delete( string id );
    void   Set( byte[] data, string id, string version = null );
    byte[] Get( string id );
    bool   Has( string id );
    bool   MatchesVersion( string id, string version );
    void   DeleteAll();
}
