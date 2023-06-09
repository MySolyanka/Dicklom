import React from "react";
import "./App.css";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import { About } from "./home";
import { LoginForm } from "./login";

function App() {
  return (
    <Router>
      <Routes>
        <Route exact path="/" element={<LoginForm />} />
        <Route path="/home" element={<About />} />
      </Routes>
    </Router>
  );
}

export default App;
