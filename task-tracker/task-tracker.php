<?php

define('TASKS_FILE', 'tasks.json');

function loadTasks() {
    if (!file_exists(TASKS_FILE)) {
        return [];
    }
    $tasksJson = file_get_contents(TASKS_FILE);
    return json_decode($tasksJson, true);
}

function saveTasks($tasks) {
    file_put_contents(TASKS_FILE, json_encode($tasks, JSON_PRETTY_PRINT));
}

function addTask($description) {
    $tasks = loadTasks();
    $maxId = 0;
    foreach ($tasks as $task) {
        if ($task['id'] > $maxId) {
            $maxId = $task['id'];
        }
    }
    $id = $maxId + 1;
    $newTask = [
        'id' => $id,
        'description' => $description,
        'status' => 'todo',
        'createdAt' => date('d-m-Y H:i'),
        'updatedAt' => date('d-m-Y H:i'),
    ];
    $tasks[] = $newTask;
    saveTasks($tasks);
    echo "Task added successfully (ID: $id)\n";
}

function updateTask($id, $description) {
    $tasks = loadTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['description'] = $description;
            $task['updatedAt'] = date('d-m-Y H:i');
            saveTasks($tasks);
            echo "Task updated successfully (ID: $id)\n";
            return;
        }
    }
    echo "Task not found (ID: $id)\n";
}

function deleteTask($id) {
    $tasks = loadTasks();
    foreach ($tasks as $index => $task) {
        if ($task['id'] == $id) {
            array_splice($tasks, $index, 1);
            saveTasks($tasks);
            echo "Task deleted successfully (ID: $id)\n";
            return;
        }
    }
    echo "Task not found (ID: $id)\n";
}

function markInProgress($id) {
    $tasks = loadTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            if ($task['status'] == 'done') {
                echo "Cannot mark a done task as in-progress\n";
                return;
            }
            $task['status'] = 'in-progress';
            $task['updatedAt'] = date('d-m-Y H:i');
            saveTasks($tasks);
            echo "Task marked as in-progress (ID: $id)\n";
            return;
        }
    }
    echo "Task not found (ID: $id)\n";
}

function markDone($id) {
    $tasks = loadTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            if ($task['status'] == 'in-progress') {
                $task['status'] = 'done';
                $task['updatedAt'] = date('d-m-Y H:i');
                saveTasks($tasks);
                echo "Task marked as done (ID: $id)\n";
                return;
            } else {
                echo "Task is already marked as done or todo\n";
                return;
            }
        }
    }
    echo "Task not found (ID: $id)\n";
}

function listTasks($status = null) {
    $tasks = loadTasks();
    $filteredTasks = array_filter($tasks, function($task) use ($status) {
        if ($status === null) {
            return true;
        }
        return $task['status'] === $status;
    });
    
    if (empty($filteredTasks)) {
        echo "No tasks found\n";
        return;
    }

    foreach ($filteredTasks as $task) {
        echo "ID: {$task['id']} | Description: {$task['description']} | Status: {$task['status']} | Created At: {$task['createdAt']} | Updated At: {$task['updatedAt']}\n";
    }
}

if ($argc < 2) {
    echo "Usage: php task-tracker.php [command] [arguments]\n";
    exit(1);
}

$command = $argv[1];

switch ($command) {
    case 'add':
        if ($argc < 3) {
            echo "Usage: php task-tracker.php add \"Task description\"\n";
            exit(1);
        }
        $description = $argv[2];
        addTask($description);
        break;

    case 'update':
        if ($argc < 4) {
            echo "Usage: php task-tracker.php update [id] \"Updated task description\"\n";
            exit(1);
        }
        $id = (int) $argv[2];
        $description = $argv[3];
        updateTask($id, $description);
        break;

    case 'delete':
        if ($argc < 3) {
            echo "Usage: php task-tracker.php delete [id]\n";
            exit(1);
        }
        $id = (int) $argv[2];
        deleteTask($id);
        break;

    case 'mark-in-progress':
        if ($argc < 3) {
            echo "Usage: php task-tracker.php mark-in-progress [id]\n";
            exit(1);
        }
        $id = (int) $argv[2];
        markInProgress($id);
        break;

    case 'mark-done':
        if ($argc < 3) {
            echo "Usage: php task-tracker.php mark-done [id]\n";
            exit(1);
        }
        $id = (int) $argv[2];
        markDone($id);
        break;

    case 'list':
        if ($argc > 3) {
            echo "Usage: php task-tracker.php list [status]\n";
            exit(1);
        }
        $status = isset($argv[2]) ? $argv[2] : null;
        listTasks($status);
        break;

    default:
        echo "Unknown command: $command\n";
        break;
}
  