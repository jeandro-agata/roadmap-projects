# task-tracker

This is a simple CLI tasktracker. It can:
- Add, Update, and Delete tasks
- Mark a task as in progress or done
- List tasks (all, done, not done and in progress)

Commands:

Add a new task: 
php task-tracker.php add "Task description"

Update a task's description: 
php task-tracker.php update [task_id] "Updated task description"

Delete a task: 
php task-tracker.php delete [task_id]

Mark a task as in-progress: 
php task-tracker.php mark-in-progress [task_id]

Mark a task as done: 
php task-tracker.php mark-done [task_id]

List tasks or filter by status (todo, in-progress, done): 
php task-tracker.php list [status]

