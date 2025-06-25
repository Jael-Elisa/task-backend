<?php
require_once __DIR__ . '/../models/WeeklyTask.php';

class WeeklyTaskController {
    public static function index() {
        $tasks = WeeklyTask::all();
        echo json_encode($tasks);
    }

    public static function store($data) {
        $task = WeeklyTask::create($data);
        echo json_encode($task);
    }

    public static function update($data) {
        $updated = WeeklyTask::update($data);
        echo json_encode($updated);
    }

    public static function delete($id) {
        $success = WeeklyTask::delete($id);
        echo json_encode(['success' => $success]);
    }
}
