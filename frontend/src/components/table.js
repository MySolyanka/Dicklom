import * as React from "react";
import { DataGrid } from "@mui/x-data-grid";
import "../assets/table.css";

const columns = [
  { field: "completed", headerName: "completed", width: 150 },
  { field: "id", headerName: "ID", width: 150 },
  { field: "title", headerName: "title", width: 150 },
  { field: "userId", headerName: "userId", width: 150 },
  // { field: "firstName", headerName: "First name", width: 130 },
  // { field: "lastName", headerName: "Last name", width: 130 },
  // {
  //   field: "age",
  //   headerName: "Age",
  //   type: "number",
  //   width: 90,
  // },
  // {
  //   field: "fullName",
  //   headerName: "Full name",
  //   description: "This column has a value getter and is not sortable.",
  //   sortable: false,
  //   width: 160,
  //   valueGetter: (params) =>
  //     `${params.row.firstName || ""} ${params.row.lastName || ""}`,
  // },
];

const rows = [];

function DataTable() {
  const [rows, setRows] = React.useState([]);

  React.useEffect(() => {
    fetch("https://jsonplaceholder.typicode.com/todos/1")
      .then((response) => {
        if (response.ok) {
          return response.json();
        }
        throw new Error(`${response.status} ${response.statusText}`);
      })
      .then((data) => {
        console.log(data);
        setRows([data]);
      })
      .catch((err) => {
        console.log(err);
      });
  }, []);

  return (
    <div>
      <DataGrid
        className="dataGrid"
        rows={rows}
        columns={columns}
        initialState={{
          pagination: {
            paginationModel: { page: 0, pageSize: 5 },
          },
        }}
        pageSizeOptions={[5, 10]}
        checkboxSelection
      />
    </div>
  );
}

export { DataTable };
