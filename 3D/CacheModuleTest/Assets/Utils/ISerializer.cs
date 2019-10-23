using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public interface ISerializer  {

    string Serialize( object obj );
    void Deserialize( string txt, object obj );
}
