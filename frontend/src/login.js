import React, { useState } from "react";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import "./login.css";

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
    const confirm = true;
    if (confirm) {
      //проверка логина и пароль на существование, удали после проверки!!! При нажатии на кнопку, логин и пароль будет выведен в консоль
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
            return response.json();
          }
          throw new Error("Network response was not ok.");
        })
        .then((data) => {
          console.log(data);
          if (redirect) {
            navigate("/home");
          }
        })
        .catch((error) => {
          console.error(error);
        });
    }
    setLogin("");
    setPassword("");
  };

  return (
    <form onSubmit={handleSubmit} className="form">
      <div className="formGroup">
        <label className="label">Логин:</label>
        <input
          type="text"
          value={login}
          onChange={handleLoginChange}
          className="input"
        />
      </div>
      <div className="formGroup">
        <label className="label">Пароль:</label>
        <input
          type="password"
          value={password}
          onChange={handlePasswordChange}
          className="input"
        />
      </div>
      <button type="submit" className="button">
        Войти
      </button>
    </form>
  );
};

export { LoginForm };
