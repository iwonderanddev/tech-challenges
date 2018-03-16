# IWD 3D developer challenge

## Setup

Unity3D, a C# editor and few 3d meshes of your choice.

## Guidelines

We want to see how you tackle a technical problem.

## Content

The exercise consists in developing a camera focus on objects in the scene. Let's consider in that problem that we have a single camera in the scene using the perspective projection mode and you placed some items in the scene (whatever items you want).

When you play the application, your script should position the camera correctly and smoothly (using Vector3.Lerp for instance) so that all objects are rendered entirely (no cropped objects in the camera rendering) while preserving its rotation, its vertical and horizontal field of view.

The only non visible objects should be the ones occluded by others.

The script should work no matter the initial camera orientation, the number of objects and their position in the scene.

### Bonus

> This is not mandatory, add this feature if you feel like it.

Make this works also for an orthographic projection camera.