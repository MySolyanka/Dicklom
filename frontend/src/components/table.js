import * as React from "react";
import { DataGrid } from "@mui/x-data-grid";
import "../assets/table.css";

const columns = [
  { field: "id", headerName: "ID", width: 150 },
  { field: "group_name", headerName: "group_name", width: 150 },
  { field: "group_number", headerName: "group_number", width: 150 },
  { field: "sender_name", headerName: "sender_name", width: 150 },
  { field: "message_topic", headerName: "message_topic", width: 150 },
  { field: "message_text", headerName: "message_text", width: 150 },
  { field: "file", headerName: "file", width: 150 },
];

function DataTable() {
  const [rows, setRows] = React.useState([]);

  React.useEffect(() => {
    fetch("http://localhost:8000/api/data")
      .then((response) => {
        if (response.ok) {
          return response.json();
        }
        throw new Error(`${response.status} ${response.statusText}`);
      })
      .then((data) => {
        console.log(data);
        setRows(data);
      })
      .catch((err) => {
        console.log(err);
      });
  }, []);

  const handleRowClick = (params) => {
    console.log("Clicked Row:", params.row);
    // логика клика
  };

  return (
    <div style={{ height: 600, width: "100%" }}>
      <DataGrid
        className="dataGrid"
        rows={rows}
        columns={columns}
        onRowClick={handleRowClick}
        pageSize={5}
      />
    </div>
  );
}

export { DataTable };
