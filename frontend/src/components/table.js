import * as React from "react";
import { DataGrid } from "@mui/x-data-grid";
import "../assets/table.css";
import { useNavigate } from "react-router-dom";

const columns = [
  { field: "id", headerName: "ID", width: 150 },
  { field: "group_name", headerName: "Группа", width: 150 },
  { field: "group_number", headerName: "Курс", width: 150 },
  { field: "sender_name", headerName: "Отправитель", width: 150 },
  { field: "message_topic", headerName: "Тема", width: 150 },
  { field: "message_text", headerName: "Информация", width: 150 },
  { field: "file", headerName: "Прикреплённый файл", width: 150 },
];

function DataTable() {
  const navigate = useNavigate();
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
        setRows(data);
      })
      .catch((err) => {
        console.log(err);
      });
  }, []);

  const handleRowClick = (params) => {
    const itemId = params.row.id;
    navigate(`/home/${itemId}`);
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
