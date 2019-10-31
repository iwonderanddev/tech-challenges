using System;

[ Serializable ]
public class CacheEntry<T>
{
    public T      Data;
    public string Id;
    public string LastUseDate;
    public string Version;

    public CacheEntry( string id, string version, T data, string lastUseDate )
    {
        Id = id;
        Version = version;
        LastUseDate = lastUseDate;
        Data = data;
    }
}
