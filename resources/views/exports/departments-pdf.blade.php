<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Departments Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            display: table-header-group; /* repeated on each page */
        }

        th, td {
            border: 1px solid #aaa;
            padding: 6px 8px;
        }

        th {
            background-color: #343a40;
            color: #fff;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td.center {
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            color: #fff;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-active {
            background-color: #28a745; /* green */
        }

        .status-inactive {
            background-color: #dc3545; /* red */
        }
    </style>
</head>
<body>
    <h2>Department List</h2>

    <table>
        <thead>
            <tr>
                <th class="center">ID</th>
                <th>UUID</th>
                <th>Department Name</th>
                <th class="center">Status</th>
                <th>Created By</th>
                <th>Updated By</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $dept)
                <tr>
                    <td class="center">{{ $dept['id'] }}</td>
                    <td>{{ $dept['uuid'] }}</td>
                    <td>{{ $dept['department_name'] }}</td>
                    <td class="center">
                        <span class="status-badge {{ strtolower($dept['status']) === 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($dept['status']) }}
                        </span>
                    </td>
                    <td>{{ $dept['created_by_name'] }}</td>
                    <td>{{ $dept['updated_by_name'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($dept['created_at'])->format('d-M-Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($dept['updated_at'])->format('d-M-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
