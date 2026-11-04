<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OIDC Debug Client</title>
    <style>
        /* Modern Reset & Variables */
        :root {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --primary-danger: #dc2626;
            --primary-danger-hover: #b91c1c;
            --code-bg: #0f172a;
            --code-text: #e2e8f0;
            --radius: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-color);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: var(--text-main);
            line-height: 1.5;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header Card */
        .header-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .header-title h1 {
            font-size: 1.25rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
        }

        .header-title p {
            font-size: 0.75rem;
            font-family: monospace;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Button Logout */
        .btn-logout {
            background-color: var(--primary-danger);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-logout:hover {
            background-color: var(--primary-danger-hover);
        }

        /* Content Card */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background-color: #f8fafc;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }

        /* Data List (Ganti Table) */
        .data-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .data-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .data-value {
            font-size: 0.875rem;
        }

        .data-value.mono {
            font-family: monospace;
            background: #f1f5f9;
            padding: 0.125rem 0.375rem;
            border-radius: 4px;
            word-break: break-all;
            display: inline-block;
        }

        /* Raw Data Pre block */
        .raw-container {
            padding: 1.5rem;
            background-color: var(--code-bg);
            color: var(--code-text);
            font-family: monospace;
            font-size: 0.8125rem;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }

        @media (max-width: 600px) {
            .data-row {
                grid-template-columns: 1fr;
                gap: 0.25rem;
            }
            .header-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .btn-logout {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- Header -->
        <div class="header-card">
            <div class="header-title">
                <h1><span class="status-dot"></span> OIDC Debugger</h1>
                <p>/resources/views/debug.blade.php</p>
            </div>

            <form method="POST" action="{{ route('laracloak.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    Logout dari IDP
                </button>
            </form>
        </div>

        <!-- Core Claims -->
        <div class="card">
            <div class="card-header">Core User Claims</div>

            <div class="data-row">
                <div class="data-label">Sub (IDP Key)</div>
                <div class="data-value"><span class="mono">{{ $user->sub ?? '-' }}</span></div>
            </div>

            <div class="data-row">
                <div class="data-label">Nama</div>
                <div class="data-value" style="font-weight: 600;">{{ $user->name ?? '-' }}</div>
            </div>
        </div>

        <!-- Raw JSON Dump -->
        <div class="card">
            <div class="card-header">Raw IDP Data (Object Dump)</div>
            <div class="raw-container"><pre>@if(method_exists($user, 'toArray')){{ json_encode($user->toArray(), JSON_PRETTY_PRINT) }}@elseif(isset($user->attributes)){{ json_encode($user->attributes, JSON_PRETTY_PRINT) }}@else{{ json_encode($user, JSON_PRETTY_PRINT) }}@endif</pre></div>
        </div>

    </div>

</body>
</html>
