<?php
require_once "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>lb3</title>
	</head>
	<body>
		<div>
			<p>інформація про виконані завдання за обраним проєктом на зазначену дату;</p>
			ID:
			<select id="projectID">
				<?php
                try {
				$sql = "SELECT ID_Projects FROM PROJECT";
                $stmt = $connection->prepare($sql);
				$stmt->execute(); 
				$cursor = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($cursor as $id) {
					echo "<option>" . $id["ID_Projects"] . "</option>";
				}
				} catch (PDOException $ex) {
					echo $ex->getMessage(); 
				}
                ?>
			</select>
			<input type="date" name="date" id="dateF" value="2019-04-16" />
			<button id="get-text">Отримати текст</button>
			<p>Результат запиту: </p>
			<div id="text-resp">Результату ще немає</div>
		</div>

		<div>
			<p>загальний час роботи над обраним проєктом;</p>
			ID:
			<select id="projectID2">
				<?php
                try {
					$sql = "SELECT ID_Projects FROM PROJECT";
					$stmt = $connection->prepare($sql);
					$stmt->execute(); 
					$cursor = $stmt->fetchAll(PDO::FETCH_ASSOC); 
					foreach ($cursor as $id) {
						echo "<option>" . $id["ID_Projects"] . "</option>";
					}
					} catch (PDOException $ex) {
						echo $ex->getMessage(); 
					}
                ?>
			</select>
			<button id="get-xml">Отримати XML</button>
			<p>Результат запиту: </p>
			<div id="xml-resp">Результату ще немає</div>
		</div>

		<div>
			<p>кількість співробітників відділу обраного керівника.</p>
			Chief:
			<select id="chief">
				<?php
                try {
				$sql = "SELECT chief FROM DEPARTMENT";
                $stmt = $connection->prepare($sql);
				$stmt->execute(); 
				$cursor = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($cursor as $chief) {
					echo "<option>" . $chief["chief"] . "</option>";
				}
				} catch (PDOException $ex) {
					echo $ex->getMessage(); 
				}
                ?>
			</select>
			<button id="get-json">Отримати JSON</button>
			<p>Результат запиту: </p>
			<div id="json-resp">Результату ще немає</div>
		</div>

		<script>
		const textResp = document.getElementById("text-resp");
		const textBtn = document.getElementById("get-text");
		textBtn.addEventListener("click", () => {
			const projectID = document.getElementById("projectID").value;
			const dateF = document.getElementById("dateF").value;
			const ajax = new XMLHttpRequest();
			ajax.open("GET", "getDescription.php?projectID=" + projectID + "&dateF=" + dateF);
			ajax.onload = () => {
				console.log(ajax);
				textResp.innerHTML = ajax.responseText;
			};
			ajax.send();
		});

		const xmlResp = document.getElementById("xml-resp");
		const xmlBtn = document.getElementById("get-xml");
		xmlBtn.addEventListener("click", () => {
			const ajax = new XMLHttpRequest();
			const projectID2 = document.getElementById("projectID2").value;
			ajax.open("GET", "totalTime.php?projectID=" + projectID2);
			ajax.onload = () => {
				let html = '';
				const xmlDoc = ajax.responseXML;
				const resp = xmlDoc.getElementsByTagName("time");
				html += resp[0].childNodes[0].nodeValue;
				xmlResp.innerHTML = html;
			};
			ajax.send();
		});

		const jsonResp = document.getElementById("json-resp");
		const jsonBtn = document.getElementById("get-json");
		jsonBtn.addEventListener("click", () => {
			const chief = document.getElementById("chief").value;
			const ajax = new XMLHttpRequest();
			ajax.onload = () => {
				const data = JSON.parse(ajax.responseText);
				let html = "";
				html += "Загальна кількість робітників: "+ data.total_workers;
				jsonResp.innerHTML = html;
			};
			ajax.open("GET", "workersAmount.php?chief=" + chief);
			ajax.send();
		});
	</script>
	</body>
</html>
