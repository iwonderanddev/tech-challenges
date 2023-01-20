# IWD junior *integrator* challenge

## The Test

Based on a CSV file listing & describing stories, **code a solution that create all stories in a Kanban in [Shortcut App](https://app.shortcut.com/)**

- Use [Shortcut REST API](https://shortcut.com/api/rest/v3)
- Group by stories status
- Assigned stories with their epic
- Link stories to their parent

### Domain

Below, we explain all domain entities you need to work with.

> ⏱ **Don't lose time**
>
> So you don't spend hours looking for the right API endpoint, we've already listed them in this section.

#### Story

A story is composed of:
- A `description`.
- A `status`.
- An `epic`.
- A `parent task`, that block the current task.

Here's an extract of the *stories.csv* file that list all stories for this test. 

| description                      | status      | epic    | blocked by                       |
|----------------------------------|-------------|---------|----------------------------------|
| Tech challenge accepted!         | done        | Prepare |                                  |
| Read & Understand tech challenge | done        | Prepare | Tech challenge accepted!         |

[Shortcut Stories API](https://shortcut.com/api/rest/v3#Stories)

#### Epic

An Epic is a collection of tasks. 1 task belongs to 1 epic, 1 epic can have many tasks.

[Shortcut Epic API](https://shortcut.com/api/rest/v3#Epics)

#### Workflow & Status

A status represents the work state of a task. It can be `to do`, `in progress` or `done`.  
In [Shortcut](https://app.shortcut.com/), this concept is named [Workflow](https://shortcut.com/api/rest/v3#Workflows).
A workflow has [states](https://shortcut.com/api/rest/v3#WorkflowState).

> ⚠️ **Must Read**  
> 
> You will need to create the workflow and its states manually on the [Shortcut App](https://app.shortcut.com/), and then fetch them with their API.

### Ready? Code!

#### Guidelines

We want to see your skills to design business code to produce **efficient** and **maintainable** code over time.

Keep in mind to:

- Stay in your area of expertise. *Don't try this super new fancy framework on this exercise...*
- Architecture your code
- Use consistent code styles
- Use dependency management
- Use others dependencies if you want/need

#### Step 1

- Get your hand on [Shortcut](https://app.shortcut.com/) and play with it a bit.
- Prepare your Workflow in [Shortcut](https://app.shortcut.com/). It should reflect stories possible states.
- Create your Shortcut API token

#### Step 2

- **You are free to use the technology you want**: NodeJS, Python, PHP...
- Bootstrap your project (use any boilerplate to optimize your time)
- Implement your script to automatically generate your stories from the CSV file.

#### Step 3

Optional step.

- Provide a UI to upload a CSV file similar to `stories.csv`
- Process the uploaded file to generate the Kanban
