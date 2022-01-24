public interface ISerializer
{
	string Serialize( object obj );
	void Deserialize( string txt, object obj );
}
