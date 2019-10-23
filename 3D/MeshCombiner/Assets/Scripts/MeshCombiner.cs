using UnityEngine;
using System.Collections.Generic;

public class MeshCombiner
{
    class MeshData
    {
        public List<int> triangles;
        public List<Vector3> vertices;
        public List<Vector3> normals;
        public List<Vector4> tangents;
        public List<Vector2> uv;
        public List<Vector2> uv2;
        public Transform transform;

        public MeshData()
        {
            triangles = new List<int>();
            vertices = new List<Vector3>();
            normals = new List<Vector3>();
            tangents = new List<Vector4>();
            uv = new List<Vector2>();
            uv2 = new List<Vector2>();
            transform = null;
        }

        public MeshData( Mesh m, Transform t )
        {
            triangles = new List<int>();
            vertices = new List<Vector3>();
            normals = new List<Vector3>();
            tangents = new List<Vector4>();
            uv = new List<Vector2>();
            uv2 = new List<Vector2>();
            transform = t;

            triangles.AddRange( m.triangles );
            vertices.AddRange( m.vertices );
            normals.AddRange( m.normals );
            tangents.AddRange( m.tangents );
            uv.AddRange( m.uv );
            uv2.AddRange( m.uv2 );

            //Debug.Log( "## Init mesh " + m.name + " data\n" );
            //Debug.Log( "vertices list : " + vertices.Count + "\n" );
            //Debug.Log( "normals list : " + normals.Count + "\n" );
            //Debug.Log( "tangents list : " + tangents.Count + "\n" );
            //Debug.Log( "uv list : " + uv.Count + "\n" );
            //Debug.Log( "uv2 list : " + uv2.Count + "\n" );
        }

        public MeshData( Mesh m, Transform t, int subMeshIndex )
        {
            int vertexCount = m.vertexCount;
            triangles = new List<int>( vertexCount );
            vertices = new List<Vector3>( vertexCount );
            normals = new List<Vector3>( vertexCount );
            tangents = new List<Vector4>( vertexCount );
            uv = new List<Vector2>( vertexCount );
            uv2 = new List<Vector2>( vertexCount );
            transform = t;

            int[] mTriangles = m.GetTriangles( subMeshIndex );
            Vector3[] mVertices = m.vertices;
            Vector3[] mNormals = m.normals;
            Vector4[] mTangents = m.tangents;
            Vector2[] mUv = m.uv;
            Vector2[] mUv2 = m.uv2;

            if( mNormals != null && mNormals.Length != mVertices.Length )
            {
                mNormals = null;
            }
            if( mTangents != null && mTangents.Length != mVertices.Length )
            {
                mTangents = null;
            }
            if( mUv != null && mUv.Length != mVertices.Length )
            {
                mUv = null;
            }
            if( mUv2 != null && mUv2.Length != mVertices.Length )
            {
                mUv2 = null;
            }

            Dictionary<int, int> indexMap = new Dictionary<int, int>();

            for( int i = 0; i < mTriangles.Length; ++i )
            {
                int index = mTriangles[ i ];
                int mappedIndex = 0;
                if( indexMap.TryGetValue( index, out mappedIndex ) )
                {
                    triangles.Add( mappedIndex );
                }
                else
                {
                    mappedIndex = vertices.Count;
                    indexMap.Add( index, mappedIndex );

                    if( mVertices != null )
                    {
                        vertices.Add( mVertices[ index ] );
                    }
                    if( mNormals != null )
                    {
                        normals.Add( mNormals[ index ] );
                    }
                    if( mTangents != null )
                    {
                        tangents.Add( mTangents[ index ] );
                    }
                    if( mUv != null )
                    {
                        uv.Add( mUv[ index ] );
                    }
                    if( mUv2 != null )
                    {
                        uv2.Add( mUv2[ index ] );
                    }

                    triangles.Add( mappedIndex );
                }
            }

            //Debug.Log( "## Init multi-submesh " + m.name + " data\n" );
            //Debug.Log( "vertices : " + mVertices.Length + "  list : " + vertices.Count + "\n" );
            //Debug.Log( "normals : " + mNormals.Length + "  list : " + normals.Count + "\n" );
            //Debug.Log( "tangents : " + mTangents.Length + "  list : " + tangents.Count + "\n" );
            //Debug.Log( "uv : " + mUv.Length + "  list : " + uv.Count + "\n" );
            //Debug.Log( "uv2 : " + mUv2.Length + "  list : " + uv2.Count + "\n" );
        }

        public void ClearData()
        {
            triangles.Clear();
            vertices.Clear();
            normals.Clear();
            tangents.Clear();
            uv.Clear();
            uv2.Clear();
            transform = null;
        }

        ~MeshData()
        {
            ClearData();
            triangles = null;
            vertices = null;
            normals = null;
            tangents = null;
            uv = null;
            uv2 = null;
        }
    }

    /// <summary>
    /// Combine all meshes found in rootTransform hierarchy in one mesh preserving all materials
    /// </summary>
    /// <param name="rootTransform">root transform of required object hierarchy to combine</param>
    /// <returns>The combined mesh object transform if several meshes were found. The original transform otherwise</returns>
    public static Transform CombineMeshes( Transform rootTransform )
    {
        MeshFilter[] mfs = rootTransform.GetComponentsInChildren<MeshFilter>();

        if( mfs != null && mfs.Length > 1 )
        {
            List<Material> usedMaterials = new List<Material>();
            Dictionary<int, List<MeshData>> meshesData = new Dictionary<int, List<MeshData>>();
            for( int i = 0; i < mfs.Length; ++i )
            {
                MeshFilter mf = mfs[ i ];
                MeshRenderer mr = mf.GetComponent<MeshRenderer>();
                if( mr != null )
                {
                    Material[] mats = mr.sharedMaterials;
                    if( mats != null )
                    {
                        int subMeshCount = mf.sharedMesh.subMeshCount;
                        for( int j = 0; j < mats.Length; ++j )
                        {
                            Material mat = mats[ j ];
                            int combinedMeshMatIndex = usedMaterials.IndexOf( mat );
                            if( combinedMeshMatIndex < 0 )
                            {
                                combinedMeshMatIndex = usedMaterials.Count;
                                usedMaterials.Add( mat );
                                meshesData.Add( combinedMeshMatIndex, new List<MeshData>() );
                            }

                            if( subMeshCount > 1 )
                            {
                                meshesData[ combinedMeshMatIndex ].Add( new MeshData( mf.sharedMesh, mf.transform, j ) );
                            }
                            else
                            {
                                meshesData[ combinedMeshMatIndex ].Add( new MeshData( mf.sharedMesh, mf.transform ) );
                            }
                        }
                    }
                }
            }

            Transform combinedTransform = new GameObject( "combined" ).transform;
            combinedTransform.parent = rootTransform.parent;
            combinedTransform.localPosition = rootTransform.localPosition;
            combinedTransform.localRotation = rootTransform.localRotation;
            combinedTransform.localScale = rootTransform.localScale;

            MeshFilter combinedMf = combinedTransform.gameObject.AddComponent<MeshFilter>();
            MeshRenderer combinedMr = combinedTransform.gameObject.AddComponent<MeshRenderer>();

            Mesh combinedMesh = new Mesh();
            combinedMesh.subMeshCount = usedMaterials.Count;

            MeshData finalMeshData = new MeshData();
            List<List<int>> subMeshesTriangles = new List<List<int>>();


            // ( contentFlags & 1 ) != 0 means final mesh has normals
            // ( contentFlags & 2 ) != 0 means final mesh has tangents
            // ( contentFlags & 4 ) != 0 means final mesh has uv
            // ( contentFlags & 8 ) != 0 means final mesh has uv2
            int contentFlags = 0;
            for( int i = 0; i < usedMaterials.Count; ++i )
            {
                List<MeshData> meshDataList = meshesData[ i ];
                for( int j = 0; j < meshDataList.Count; ++j )
                {
                    MeshData meshData = meshDataList[ j ];
                    if( meshData.normals.Count > 0 )
                    {
                        contentFlags |= 1;
                    }
                    if( meshData.tangents.Count > 0 )
                    {
                        contentFlags |= 2;
                    }
                    if( meshData.uv.Count > 0 )
                    {
                        contentFlags |= 4;
                    }
                    if( meshData.uv2.Count > 0 )
                    {
                        contentFlags |= 8;
                    }

                    if( contentFlags == 15 )
                        break;
                }

                if( contentFlags == 15 )
                    break;
            }

            for( int i = 0; i < usedMaterials.Count; ++i )
            {
                List<MeshData> meshDataList = meshesData[ i ];
                List<int> subMeshTriangles = new List<int>();
                subMeshesTriangles.Add( subMeshTriangles );
                for( int j = 0; j < meshDataList.Count; ++j )
                {
                    MeshData meshData = meshDataList[ j ];
                    int offset = finalMeshData.vertices.Count;

                    if( ( contentFlags & 1 ) != 0 )
                    {
                        if( meshData.normals.Count < meshData.vertices.Count )
                        {
                            Debug.LogWarning( "Adding " + ( meshData.vertices.Count - meshData.normals.Count ) + " missing normals as vertices and normals arrays count differ. vertices count : " + meshData.vertices.Count +
                                              "  normals count : " + meshData.normals.Count + "\n", meshData.transform );
                        }
                        else if( meshData.normals.Count > meshData.vertices.Count )
                        {
                            Debug.LogError( "There are more normals than vertices in mesh! Something is really wrong!\n", meshData.transform );
                        }
                    }

                    if( ( contentFlags & 2 ) != 0 )
                    {
                        if( meshData.tangents.Count < meshData.vertices.Count )
                        {
                            Debug.LogWarning( "Adding " + ( meshData.vertices.Count - meshData.tangents.Count ) + " missing tangents as vertices and tangents arrays count differ. vertices count : " + meshData.vertices.Count +
                                              "  tangents count : " + meshData.tangents.Count + "\n", meshData.transform );
                        }
                        else if( meshData.tangents.Count > meshData.vertices.Count )
                        {
                            Debug.LogError( "There are more tangents than vertices in mesh! Something is really wrong!\n", meshData.transform );
                        }
                    }

                    for( int k = 0; k < meshData.vertices.Count; ++k )
                    {
                        finalMeshData.vertices.Add( combinedTransform.InverseTransformPoint( meshData.transform.TransformPoint( meshData.vertices[ k ] ) ) );
                        if( meshData.normals.Count > k )
                        {
                            finalMeshData.normals.Add( combinedTransform.InverseTransformDirection( meshData.transform.TransformDirection( meshData.normals[ k ] ) ) );
                        }
                        else if( ( contentFlags & 1 ) != 0 )
                        {
                            finalMeshData.normals.Add( Vector3.zero );
                        }
                        if( meshData.tangents.Count > k )
                        {
                            finalMeshData.tangents.Add( combinedTransform.InverseTransformDirection( meshData.transform.TransformDirection( meshData.tangents[ k ] ) ) );
                        }
                        else if( ( contentFlags & 2 ) != 0 )
                        {
                            finalMeshData.tangents.Add( Vector3.zero );
                        }
                    }

                    if( ( contentFlags & 4 ) != 0 )
                    {
                        finalMeshData.uv.AddRange( meshData.uv );
                        if( meshData.uv.Count < meshData.vertices.Count )
                        {

                            int missingCount = meshData.vertices.Count - meshData.uv.Count;
                            Debug.LogWarning( "Adding " + missingCount + " missing uv as vertices and uv arrays count differ. vertices count : " + meshData.vertices.Count +
                                              "  uv count : " + meshData.uv.Count + "\n", meshData.transform );

                            for( int k = 0; k < missingCount; ++k )
                            {
                                finalMeshData.uv.Add( Vector2.zero );
                            }
                        }
                        else if( meshData.uv.Count > meshData.vertices.Count )
                        {
                            Debug.LogError( "There are more uv than vertices in mesh! Something is really wrong!\n", meshData.transform );
                        }
                    }

                    if( ( contentFlags & 8 ) != 0 )
                    {
                        finalMeshData.uv2.AddRange( meshData.uv2 );
                        if( meshData.uv2.Count < meshData.vertices.Count )
                        {
                            int missingCount = meshData.vertices.Count - meshData.uv2.Count;
                            Debug.LogWarning( "Adding " + missingCount + " missing uv2 as vertices and uv2 arrays count differ. vertices count : " + meshData.vertices.Count +
                                              "  uv2 count : " + meshData.uv2.Count + "\n", meshData.transform );

                            for( int k = 0; k < missingCount; ++k )
                            {
                                finalMeshData.uv2.Add( Vector2.zero );
                            }
                        }
                        else if( meshData.uv2.Count > meshData.vertices.Count )
                        {
                            Debug.LogError( "There are more uv2 than vertices in mesh! Something is really wrong! transform\n", meshData.transform );
                        }
                    }

                    for( int k = 0; k < meshData.triangles.Count; ++k )
                    {
                        meshData.triangles[ k ] += offset;
                    }
                    subMeshTriangles.AddRange( meshData.triangles );
                }
            }

            //Debug.Log( "finalMeshData vertices : " + finalMeshData.vertices.Count +
            //           "  normals : " + finalMeshData.normals.Count +
            //           "  tangents : " + finalMeshData.tangents.Count +
            //           "  uv : " + finalMeshData.uv.Count +
            //           "  uv2 : " + finalMeshData.uv2.Count );

            combinedMesh.vertices = finalMeshData.vertices.ToArray();
            combinedMesh.normals = finalMeshData.normals.ToArray();
            combinedMesh.tangents = finalMeshData.tangents.ToArray();
            combinedMesh.uv = finalMeshData.uv.ToArray();
            combinedMesh.uv2 = finalMeshData.uv2.ToArray();

            for( int i = 0; i < subMeshesTriangles.Count; ++i )
            {
                combinedMesh.SetTriangles( subMeshesTriangles[ i ].ToArray(), i );
            }
            combinedMesh.RecalculateBounds();

            combinedMf.sharedMesh = combinedMesh;
            combinedMr.sharedMaterials = usedMaterials.ToArray();

            finalMeshData = null;
            usedMaterials.Clear();
            meshesData.Clear();

            return combinedTransform;
        }

        return rootTransform;
    }
}