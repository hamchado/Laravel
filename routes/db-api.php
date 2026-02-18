<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// API Routes for Database Admin
Route::middleware(['web'])->prefix('db-admin/api')->group(function () {
    Route::get('/tables', function () {
        try {
            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
            return response()->json([
                'tables' => array_column($tables, 'tablename')
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    Route::get('/stats', function () {
        try {
            // Database size
            $size = DB::selectOne("SELECT pg_size_pretty(pg_database_size('multaqa platform')) as db_size");
            
            // Table count
            $tableCount = DB::selectOne("SELECT COUNT(*) as count FROM pg_tables WHERE schemaname = 'public'");
            
            // User count
            $userCount = DB::selectOne("SELECT COUNT(*) as count FROM users");
            
            return response()->json([
                'db_size' => $size->db_size ?? 'N/A',
                'table_count' => $tableCount->count ?? 0,
                'user_count' => $userCount->count ?? 0
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
    
    Route::post('/query', function (Illuminate\Http\Request $request) {
        try {
            $results = DB::select($request->query);
            return response()->json(['results' => $results]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
});
