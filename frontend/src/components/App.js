import React from "react";
import "../assets/App.css";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import { About } from "./home";
import { LoginForm } from "./login";
import { DataTable } from "./table";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/form/:id" component={About} />
        <Route exact path="/" element={<LoginForm />} />
        <Route path="/home" element={<About />} />
        <Route path="/table" element={<DataTable />} />
      </Routes>
    </Router>
  );
}

export default App;
