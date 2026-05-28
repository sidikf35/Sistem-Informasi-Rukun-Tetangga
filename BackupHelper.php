<?php
// helpers/BackupHelper.php

class BackupHelper {
    public static function backupDatabase($pdo) {
        $backupDir = __DIR__ . '/../backup/';
        if (!file_exists($backupDir)) mkdir($backupDir, 0777, true);
        $filename = 'backup_sirt_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $backupDir . $filename;
        
        try {
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            $sql = "-- SIRT Database Backup\n-- Date: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
            foreach ($tables as $table) {
                $create = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
                $sql .= "DROP TABLE IF EXISTS `$table`;\n";
                $sql .= $create['Create Table'] . ";\n\n";
                $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    $columns = array_keys($row);
                    $values = array_map(function($v) use ($pdo) {
                        return $v === null ? 'NULL' : "'" . addslashes($v) . "'";
                    }, array_values($row));
                    $sql .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            file_put_contents($filepath, $sql);
            return ['success' => true, 'filename' => $filename];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>