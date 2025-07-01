<style>
        .dark-style {
            width: 100%;
            overflow-x: auto;
            background-color: #1e1e1e;
            color: #eee;
            padding: 1rem;
            border-radius: 8px;
        }

        .dark-style .table-controls {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .dark-style .table-controls .left-controls,
        .dark-style .table-controls .right-controls {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .dark-style select,
        .dark-style input[type="text"],
        .dark-style button {
            background-color: #2a2a2a;
            color: #eee;
            border: 1px solid #444;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
        }

        .dark-style button:hover {
            background-color: #444;
            cursor: pointer;
        }

        .dark-style table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
            min-width: 600px;
        }

        .dark-style th, .dark-style td {
            border: 1px solid #444;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        .dark-style th {
            background-color: #333;
            color: #eee;
        }

        .dark-style th.sortable {
            cursor: pointer;
        }

        .dark-style th.sorted {
            font-weight: bold;
            background-color: #555;
        }

        .dark-style .sort-icon {
            margin-left: 6px;
            font-size: 0.8em;
        }

        .dark-style .th-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .dark-style .pagination {
            margin-top: 1rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .dark-style .pagination button {
            background-color: #333;
            color: #eee;
            border: 1px solid #555;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        .dark-style .pagination .active {
            background-color: #555;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .dark-style .table-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .dark-style table {
                min-width: 600px;
            }

            .dark-style .pagination {
                justify-content: flex-start;
            }
        }
</style>