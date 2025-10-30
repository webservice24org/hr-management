<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sub Departments Export</title>
    <style>
        @page {
            margin: 50px 25px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        header {
            position: fixed;
            top: -40px;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 12px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
    <header>
        Sub Department Report - Generated on {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }}
    </header>

    <footer>
        Page <span class="page"></span>
    </footer>

    <main>
        <table>
            <thead>
                <tr>
                    <th class="center">ID</th>
                    <th>UUID</th>
                    <th>Department</th>
                    <th>Sub Department</th>
                    <th class="center">Status</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subDepartments as $sub)
                    <tr>
                        <td class="center">{{ $sub['id'] }}</td>
                        <td>{{ $sub['uuid'] }}</td>
                        <td>{{ $sub['department_name'] ?? '-' }}</td>
                        <td>{{ $sub['sub_department_name'] }}</td>
                        <td class="center">
                            <span class="status-badge {{ strtolower($sub['status']) === 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ ucfirst($sub['status']) }}
                            </span>
                        </td>
                        <td>{{ $sub['created_by_name'] ?? '-' }}</td>
                        <td>{{ $sub['updated_by_name'] ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($sub['created_at'])->format('d-M-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($sub['updated_at'])->format('d-M-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script(function($page, $pdf) {
                $font = $pdf->getFontMetrics()->get_font("Arial", "normal");
                $pdf->text(500, 820, "Page $page of {PAGE_COUNT}", $font, 10);
            });
        }
    </script>
</body>
</html>
