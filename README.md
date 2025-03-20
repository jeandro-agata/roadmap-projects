# task-tracker project link: https://roadmap.sh/projects/task-tracker

this is a simple cli tasktracker. it can:
add, update, and delete tasks
mark a task as in progress or done
list tasks (all, done, not done and in progress)

commands:

add a new task:
php task-tracker.php add "task description"

update a task's description:
php task-tracker.php update [task_id] "updated task description"

delete a task:
php task-tracker.php delete [task_id]

mark a task as in-progress:
php task-tracker.php mark-in-progress [task_id]

mark a task as done:
php task-tracker.php mark-done [task_id]

list tasks or filter by status (todo, in-progress, done):
php task-tracker.php list [status]