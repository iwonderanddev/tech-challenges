public interface ICacheStorage
{
	bool Add( string id, byte[] data );
	bool Remove( string id );
	byte[] Get( string id );
}
