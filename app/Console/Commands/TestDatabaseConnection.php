<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestDatabaseConnection extends Command
{
    protected $signature = 'db:test';
    protected $description = 'Test database connection and perform basic operations';

    public function handle()
    {
        $this->info('Testing database connection...');

        try {
            // Test basic query
            $result = DB::select('SELECT version()');
            $this->info('Successfully connected to PostgreSQL!');
            $this->info('Version: ' . $result[0]->version);

            // Test migrations table
            $hasMigrationsTable = DB::select("
                SELECT EXISTS (
                    SELECT FROM pg_tables 
                    WHERE schemaname = 'public' 
                    AND tablename = 'migrations'
                )
            ");
            
            $this->info('Migrations table exists: ' . ($hasMigrationsTable[0]->exists ? 'Yes' : 'No'));

            // List all tables
            $tables = DB::select("
                SELECT tablename 
                FROM pg_tables 
                WHERE schemaname = 'public'
            ");
            
            $this->info('Available tables:');
            foreach ($tables as $table) {
                $this->line('- ' . $table->tablename);
            }

        } catch (\Exception $e) {
            $this->error('Database error: ' . $e->getMessage());
        }
    }
}