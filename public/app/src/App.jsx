import { useEffect, useState } from "react";
import "../../styles/book.css";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import axios from "axios";
// axios.defaults.withCredentials = true;

const API_BASE = "http://localhost:3000/";
const days = [
	"Sunday",
	"Monday",
	"Tuesday",
	"Wednesday",
	"Thursday",
	"Friday",
	"Saturday",
];
const months = [
	"January",
	"February",
	"March",
	"April",
	"May",
	"June",
	"July",
	"August",
	"September",
	"October",
	"November",
	"December",
];
const APP_TIMES = [
	"08:00",
	"08:20",
	"08:40",
	"09:00",
	"09:20",
	"09:40",
	"10:00",
	"10:20",
	"10:40",
	"11:00",
	"11:20",
	"11:40",
	"13:00",
	"13:20",
	"13:40",
	"14:00",
	"14:20",
	"14:40",
	"15:00",
	"15:20",
	"15:40",
];

function nth(day) {
	if (day > 3 && day < 21) return "th";
	switch (day % 10) {
		case 1:
			return "st";
		case 2:
			return "nd";
		case 3:
			return "rd";
		default:
			return "th";
	}
}

function formatDate(date) {
	return `${days[date.getDay()]}, ${date.getDate()}${nth(date.getDate())} ${
		months[date.getUTCMonth()]
	}`;
}

function App() {
	const [selectedDate, setSelectedDate] = useState(null);
	const [selectedTime, setSelectedTime] = useState(null);
	const [availableApps, setAvailableApps] = useState(null);
	// console.log(availableApps)
	useEffect(() => {
		if (selectedDate !== null) {
			axios
				.get(`${API_BASE}getAppointments`, {
					params: { date: selectedDate },
				})
				.then((response) => {
					setAvailableApps(
						APP_TIMES.filter((el) =>
							!response.data.map((element) => element.time).includes(el)
						)
					);
				});
		} else {
			setAvailableApps(null);
		}
	}, [selectedDate]);

	return (
		<>
			{/* remove the container class before compiling  */}
			<div className="container flex justify-center gap-20">
				<Calendar
					value={null}
					minDetail="month"
					locale="EN-en"
					minDate={new Date(2023, 4, 25)}
					onClickDay={(value) => {
						if (["Saturday", "Sunday"].includes(days[value.getDay()])) {
							setSelectedDate(null);
							setSelectedTime(null);
						} else {
							setSelectedDate(formatDate(value));
							setSelectedTime("");
						}
					}}
				/>
				<div>
					{!selectedDate ? (
						<p>Select a date to view available appointments</p>
					) : (
						<div>
							<p>Date selected : {selectedDate}</p>
							<p>Select a time for your appointment from the list below</p>
							{typeof selectedTime === "string" ? (
								<select
									name=""
									id=""
									className="outline-none border-[1px] border-blue-700 p-2 mb-4 rounded-lg w-full"
									onChange={({ target }) => {
										setSelectedTime(target.value);
									}}
								>
									<option value="">--:--</option>
									{availableApps?.map((el,i) => (
										<option key={i} value={el}>{el}</option>
									))}
								</select>
							) : (
								""
							)}
						</div>
					)}
				</div>
			</div>
		</>
	);
}

export default App;
