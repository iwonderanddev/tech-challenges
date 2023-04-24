# 3D Editor - Tech challenge - Junior

## Setup

* Unity3D
* C# editor

## Guidelines

We want to see **how you approach a technical problem**, and how you structure your code and classes.
We also want to see your skills to produce efficient and maintainable code over time: consider this feature might be the beginning of a larger one destined to evolve in time.

## Content

The exercise consists in **parsing a JSON in order to build a fixture**.

A fixture is composed of several cubic parts:
* Back panel
* Header
* Footer
* Left side
* Right side
* Shelves

Each part is positioned relative to the fixture position. The unit length is millimeter.

### JSON examples

```json
{
	"width": 3000,
	"height": 400,
	"depth": 600,
	"backPanel": { "depth": 5 },
	"header": { "height": 50 },
	"footer": { "height": 100 },
	"leftSide": { "width": 80 },
	"rightSide": { "width": 80 }
}
```

```json
{
	"width": 800,
	"height": 2000,
	"depth": 200,
	"backPanel": { "depth": 5 },
	"header": { "height": 100 },
	"footer": { "height": 400 },
	"leftSide": { "width": 50 },
	"rightSide": { "width": 50 },
	"shelves": [
		{ "height": 20, "y": 800 },
		{ "height": 20, "y": 1200 },
		{ "height": 20, "y": 1600 }
	]
}
```

```json
{
	"width": 400,
	"height": 2500,
	"depth": 300,
	"backPanel": { "depth": 10 },
	"header": { "height": 50 },
	"footer": { "height": 50 },
	"leftSide": { "width": 50 },
	"rightSide": { "width": 50 },
	"shelves": [
		{ "height": 50, "y": 800 },
		{ "height": 50, "y": 1200 }
	]
}
```

You can simply hardcode the JSON string, the main goal is to parse it and render it, not to load it. Obviously the generated fixture on the scene must be based on the JSON.

### Step 1: Rendering a fixture

We want to **render one fixture.**

The result should look like this (you are free to choose the color and visual effects):

<img width="671" alt="junior-3d-fixture-rendering" src="https://user-images.githubusercontent.com/97949722/233956359-3e1f68a5-4130-4e16-b077-a527f56b930d.png">

### Step 2: Rendering multiple fixtures

We want to **load several fixtures.**
1. Hardcode a list of JSON file paths (at least 2)
1. The fixtures are loaded, parsed and generated on the scene, without overlapping

### Step 3: User interaction

We want to be able to **move a fixture**.

Here is the behavior:
1. Click on a fixture to select (no need to add a visual feedback)
1. Click somewhere on the floor (you may want to create one)
1. The fixture is moved to the new position based on the click (overlapping is allowed)


