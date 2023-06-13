import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { useParams } from "react-router-dom";

function About() {
  const navigate = useNavigate();
  const [groupName, setGroupName] = useState("");
  const [groupNumber, setGroupNumber] = useState("");
  const [senderName, setSenderName] = useState("");
  const [messageTopic, setMessageTopic] = useState("");
  const [messageText, setMessageText] = useState("");
  const [file, setFile] = useState(null);

  const handleButtonClick = () => {
    console.log("k1ek");
    navigate("/");
  };

  const handleSubmit = (e) => {
    const { id } = useParams();
    e.preventDefault();
    // Отправка данных на сервер
    const formData = new FormData(e.target);

    formData.append("group_name", groupName);
    formData.append("group_number", groupNumber);
    formData.append("sender_name", senderName);
    formData.append("message_topic", messageTopic);
    formData.append("message_text", messageText);
    formData.append("file", file);
    // ...
    for (const [key, value] of formData.entries()) {
      console.log(key, value);
    }

    if (id) {
      fetch(`http://localhost:8000/api/data?id=${id}`)
        .then((response) => {
          if (response.ok) {
            return response.json();
          }
          throw new Error(`${response.status} ${response.statusText}`);
        })
        .then((data) => {
          setGroupName(data.group_name);
          setGroupNumber(data.group_Number);
          setSenderName(data.sender_Name);
          setMessageTopic(data.message_Topic);
          setMessageText(data.message_Text);
          setFile(file);
        })
        .catch((err) => {
          console.log(err);
        });
    } else {
      fetch("http://localhost:8000/api/information", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (response.ok) {
            alert("Загрузка прошла успешно");
            setGroupName("");
            setGroupNumber("");
            setSenderName("");
            setMessageTopic("");
            setMessageText("");
            setFile(null);
            return;
          }
          throw new Error(`${response.status} ${response.statusText}`);
        })
        .catch((error) => {
          console.log(error);
        });
    }
  };

  return (
    <form onSubmit={handleSubmit} className="form-container">
      <fieldset>
        <legend>Данные группы:</legend>
        <div className="form-group">
          <label htmlFor="group-name">Наименование группы:</label>
          <input
            type="text"
            id="group-name"
            value={groupName}
            onChange={(e) => setGroupName(e.target.value)}
            maxLength="10"
            // required
          />
        </div>
        <div className="form-group">
          <label htmlFor="group-number">Курс:</label>
          <input
            type="number"
            id="group-number"
            value={groupNumber}
            onChange={(e) => setGroupNumber(e.target.value)}
            min="1"
            max="5"
            // required
          />
        </div>
      </fieldset>
      <br />
      <fieldset>
        <legend>Данные отправителя:</legend>
        <label htmlFor="sender-name">ФИО:</label>
        <input
          type="text"
          id="sender-name"
          value={senderName}
          onChange={(e) => setSenderName(e.target.value)}
          // required
        />
        <br />
        <label htmlFor="message-topic">Тема сообщения:</label>
        <input
          type="text"
          id="message-topic"
          value={messageTopic}
          onChange={(e) => setMessageTopic(e.target.value)}
          // required
        />
      </fieldset>
      <br />
      <label htmlFor="message-text">Текст сообщения:</label>
      <textarea
        id="message-text"
        value={messageText}
        onChange={(e) => setMessageText(e.target.value)}
      ></textarea>
      <br />
      <label htmlFor="file">Выберите файл:</label>
      <br />
      <input
        type="file"
        id="file"
        onChange={(e) => setFile(e.target.files[0])}
      />
      <div className="button-container">
        <input type="submit" value="Отправить" className="submit-button" />
        <br />
        <button onClick={handleButtonClick} className="cancel-button">
          Выйти
        </button>
      </div>
    </form>
  );
}

export { About };
