<!DOCTYPE html>
<html>
<head>
    <title>Database Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .btn:hover { background: #5a67d8; }
        .btn-danger { background: #e53e3e; }
        .btn-success { background: #38a169; }
        .connection-card {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
        }
        .query-box {
            width: 100%;
            height: 150px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
        }
        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .result-table th, .result-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .result-table th {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 PostgreSQL Admin Panel</h1>
        <div>
            <a href="/" class="btn">🏠 Back to App</a>
            <a href="/logout" class="btn btn-danger">🚪 Logout</a>
        </div>
    </div>
    
    <div class="container">
        <!-- Connection Info -->
        <div class="card connection-card">
            <h3>🔗 Connection Details</h3>
            <p>Host: <strong>{{ $connection['host'] }}:{{ $connection['port'] }}</strong></p>
            <p>Database: <strong>{{ $connection['dbname'] }}</strong></p>
            <p>Username: <strong>{{ $connection['username'] }}</strong></p>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
            <h3>⚡ Quick Actions</h3>
            <div>
                <a href="#tables" class="btn">📋 Show Tables</a>
                <a href="#query" class="btn">🔍 Run Query</a>
                <a href="#backup" class="btn">💾 Backup DB</a>
                <a href="#users" class="btn">👥 Manage Users</a>
            </div>
        </div>
        
        <!-- Database Tables -->
        <div class="card" id="tables">
            <h3>📁 Database Tables</h3>
            <div id="tables-list">
                Loading tables...
            </div>
        </div>
        
        <!-- SQL Query -->
        <div class="card" id="query">
            <h3>🔍 SQL Query Editor</h3>
            <textarea class="query-box" id="sql-query" placeholder="SELECT * FROM users LIMIT 10;">SELECT * FROM users LIMIT 10;</textarea>
            <button class="btn btn-success" onclick="runQuery()">▶ Run Query</button>
            <div id="query-result"></div>
        </div>
        
        <!-- Statistics -->
        <div class="card">
            <h3>📈 Database Statistics</h3>
            <div id="stats">
                Loading statistics...
            </div>
        </div>
    </div>
    
    <script>
        // Load tables on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTables();
            loadStats();
        });
        
        function loadTables() {
            fetch('/db-admin/api/tables')
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="row">';
                    data.tables.forEach(table => {
                        html += `
                            <div style="display: inline-block; margin: 5px;">
                                <div class="btn" onclick="showTable('${table}')">
                                    📊 ${table}
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    document.getElementById('tables-list').innerHTML = html;
                });
        }
        
        function loadStats() {
            fetch('/db-admin/api/stats')
                .then(response => response.json())
                .then(data => {
                    let html = `
                        <p>📦 Database Size: <strong>${data.db_size}</strong></p>
                        <p>📋 Total Tables: <strong>${data.table_count}</strong></p>
                        <p>👥 User Count: <strong>${data.user_count}</strong></p>
                    `;
                    document.getElementById('stats').innerHTML = html;
                });
        }
        
        function runQuery() {
            const query = document.getElementById('sql-query').value;
            fetch('/db-admin/api/query', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ query: query })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('query-result').innerHTML = `
                        <div style="background: #fed7d7; color: #9b2c2c; padding: 10px; border-radius: 5px; margin-top: 10px;">
                            ❌ Error: ${data.error}
                        </div>
                    `;
                } else {
                    let html = '<h4>Results:</h4>';
                    if (data.results.length > 0) {
                        html += '<table class="result-table">';
                        // Headers
                        html += '<tr>';
                        Object.keys(data.results[0]).forEach(key => {
                            html += `<th>${key}</th>`;
                        });
                        html += '</tr>';
                        // Rows
                        data.results.forEach(row => {
                            html += '<tr>';
                            Object.values(row).forEach(value => {
                                html += `<td>${value}</td>`;
                            });
                            html += '</tr>';
                        });
                        html += '</table>';
                    } else {
                        html += '<p>No results returned.</p>';
                    }
                    document.getElementById('query-result').innerHTML = html;
                }
            });
        }
        
        function showTable(tableName) {
            document.getElementById('sql-query').value = `SELECT * FROM "${tableName}" LIMIT 20;`;
            runQuery();
        }
    </script>
</body>
</html>
