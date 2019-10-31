using UnityEngine;

public class SerializerJson : ISerializer
{
	public string Serialize( object obj )
	{
		string txt = string.Empty;

		txt = JsonUtility.ToJson( obj );
		return txt;
	}

	public void Deserialize( string txt, object obj )
	{
		JsonUtility.FromJsonOverwrite( txt, obj );
	}
}
