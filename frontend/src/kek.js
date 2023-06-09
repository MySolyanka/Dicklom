import "./asd.css";
import React from "react";

const Kek = () => {
  return (
    <div class="login-container">
      <h1>Вход</h1>
      <div class="login">
        <form method="post">
          <input
            type="text"
            name="u"
            placeholder="Username"
            required="required"
          />
          <input
            type="password"
            name="p"
            placeholder="Password"
            required="required"
          />
          <button type="submit" class="btn btn-primary btn-block btn-large">
            Войти
          </button>
        </form>
      </div>
    </div>
  );
};

export { Kek };
