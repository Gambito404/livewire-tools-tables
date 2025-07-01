
    <style>
        .ligth-style {
            width: 100%;
            overflow-x: auto;
            background-color: #fff;
            color: #333;
            padding: 1rem;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .ligth-style .table-controls {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .ligth-style .table-controls .left-controls,
        .ligth-style .table-controls .right-controls {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .ligth-style select,
        .ligth-style input[type="text"],
        .ligth-style button {
            background-color: #f4f4f4;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
        }

        .ligth-style button:hover {
            background-color: #e0e0e0;
            cursor: pointer;
        }

        .ligth-style table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
            min-width: 600px; /* para scroll horizontal en móvil */
        }

        .ligth-style th, .ligth-style td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center; /* CENTRADO HORIZONTAL */
            vertical-align: middle; /* CENTRADO VERTICAL */
        }

        .ligth-style th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: 600;
        }

        .ligth-style th.sortable {
            cursor: pointer;
        }

        .ligth-style th.sorted {
            font-weight: 700;
            background-color: #e0e0e0;
        }

        .ligth-style .sort-icon {
            margin-left: 6px;
            font-size: 0.8em;
        }

        .ligth-style .th-content {
            display: flex;
            align-items: center;
            justify-content: center; /* CENTRADO */
            gap: 6px;
        }

        .ligth-style .pagination {
            margin-top: 1rem;
            display: flex;
            justify-content: flex-end; /* PAGINACION DERECHA */
            gap: 0.5rem;
        }

        .ligth-style .pagination button {
            background-color: #f4f4f4;
            color: #333;
            border: 1px solid #ccc;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        .ligth-style .pagination .active {
            background-color: #ddd;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .ligth-style .table-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .ligth-style table {
                min-width: 600px; /* scroll horizontal */
            }

            .ligth-style .pagination {
                justify-content: flex-start;
            }
        }
    </style>
