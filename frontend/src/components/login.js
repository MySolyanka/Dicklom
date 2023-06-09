import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "../assets/login.css";

const LoginForm = () => {
  const navigate = useNavigate();
  const [redirect, setRedirect] = useState(false);
  const [login, setLogin] = useState("");
  const [password, setPassword] = useState("");

  const handleLoginChange = (e) => {
    setLogin(e.target.value);
  };

  const handlePasswordChange = (e) => {
    setPassword(e.target.value);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    fetch("http://localhost:8000/api/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: login,
        password: password,
      }),
    })
      .then((response) => {
        if (response.ok) {
          setRedirect(true);
          navigate("/home");
          return response.json();
        }
        throw new Error("Network response was not ok.");
      })
      .catch((error) => {
        console.error(error);
      });

    setLogin("");
    setPassword("");
  };

  return (
    <div class="login-container">
      <h1>Вход</h1>
      <div class="login">
        <form onSubmit={handleSubmit}>
          <label>Логин:</label>
          <input type="text" value={login} onChange={handleLoginChange} />
          <label>Пароль</label>
          <input
            type="password"
            value={password}
            onChange={handlePasswordChange}
          />
          <button type="submit" class="btn btn-primary btn-block btn-large">
            Войти
          </button>
        </form>
      </div>
    </div>
  );
};

export { LoginForm };
