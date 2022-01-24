using System;
using System.Collections.Generic;

[ Serializable ]
public class CacheEntry<T>
{
	public T Data;
	public string Id;
	public string LastUseDate;
	public string Version;

	public CacheEntry( string id, string version, T data, string lastUseDate )
	{
		if( string.IsNullOrEmpty( id ) )
			throw new NullReferenceException( nameof( id ) );

		if( string.IsNullOrEmpty( version ) )
			throw new NullReferenceException( nameof( version ) );

		if( string.IsNullOrEmpty( lastUseDate ) )
			throw new NullReferenceException( nameof( lastUseDate ) );

        if( EqualityComparer<T>.Default.Equals( data, default ) )
			throw new NullReferenceException(nameof( data ) );

		Id = id;
		Version = version;
		LastUseDate = lastUseDate;
		Data = data;
	}
}
