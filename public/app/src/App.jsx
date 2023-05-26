import { useState } from "react";
import "../../styles/book.css";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import axios from "axios";
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
const days = [
	"Sunday",
	"Monday",
	"Tuesday",
	"Wednesday",
	"Thursday",
	"Friday",
	"Saturday",
];
function formatDate(date) {
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
	return `${days[date.getUTCDay()]}, ${date.getUTCDate()}${nth(
		date.getUTCDate()
	)} ${months[date.getUTCMonth()]}`;
}
function App() {
	const [selectedDate, setSelectedDate] = useState(null);
	const [selectedTime, setSelectedTime] = useState(null);
	const getTakenAppTimes = async () => {
		const response = await axios.get("http://localhost:3000/getAppointments", {
			params: { date: selectedDate },
		});
		console.log(response);
	};
	return (
		<>
			{/* remove the container class before compiling  */}
			<div className="container flex justify-center gap-20">
				<Calendar
					value={null}
					minDetail="month"
					minDate={new Date(2023, 4, 25)}
					onClickDay={(value) => {
						if (["Saturday", "Sunday"].includes(days[value.getUTCDay()])) {
							setSelectedDate(
								"You can not set an appointment for Saturday or Sunday, please choose another day."
							);
							setSelectedTime(null);
						} else {
							setSelectedDate(formatDate(value));
							getTakenAppTimes();
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
							{selectedTime ? (
								<select
									name=""
									id=""
									className="outline-none border-[1px] border-blue-700 p-2 mb-4 rounded-lg w-full"
									onChange={({ target }) => {
										setSelectedTime(target.value);
									}}
								>
									<option value="">--:--</option>
									<option value="dela3a">Hello world</option>
									<option value="banana">Hello world</option>
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
