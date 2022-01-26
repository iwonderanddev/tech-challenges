using System;

public class Log
{
	public static void LogError( string msg )
	{
		string prefix = "[ERR] [[" + DateTime.UtcNow.ToString( "G" ) + "]] ";
		UnityEngine.Debug.LogError( prefix + msg );
	}

	public static void LogInfo( string msg )
	{
		string prefix = "[INFO] [[" + DateTime.UtcNow.ToString( "G" ) + "]] ";
		UnityEngine.Debug.Log( prefix + msg );
	}
}
