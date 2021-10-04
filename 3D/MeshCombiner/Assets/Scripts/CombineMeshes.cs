using UnityEngine;
using System.Collections;

[ExecuteInEditMode]
public class CombineMeshes : MonoBehaviour
{
    [TextArea]
    [Tooltip( "Doesn't do anything. Just comments shown in inspector" )]
    public string _howTo = "Drop a game object in the \"Root Transform\" field below.\nThen enable the script - this will generate a combined mesh of all meshes found in the Root transform and its children";

    [Space(10)]

    [SerializeField]
    private Transform _rootTransform;

    private void OnEnable()
    {
        DoMeshCombine();
    }

    private void DoMeshCombine()
    {
        if (_rootTransform)
        {
            Transform combined = MeshCombiner.CombineMeshes( _rootTransform );
            if( combined != _rootTransform)
                combined.transform.Translate( Vector3.right * 0.75f );
            else
                Debug.LogWarning( "Root transform does not have multiple meshes, nothing was generated" );
        }
        else
            Debug.LogError("Root Transform is null. Set one from your scene and re-enable the script");
        enabled = false;
    }
}
