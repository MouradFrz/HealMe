import { useEffect, useState } from "react";
import "../../styles/book.css";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import axios from "axios";

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
		months[date.getMonth()]
	} ${date.getFullYear()}`;
}
function submitedDateFormat(date) {
	return `${date.getFullYear()}-${date.getMonth() + 1 <= 9 ? "0" : ""}${
		date.getMonth() + 1
	}-${date.getDate() <= 9 ? "0" : ""}${date.getDate()}`;
}
function App() {
	const [selectedDate, setSelectedDate] = useState(null);
	const [selectedTime, setSelectedTime] = useState(null);
	const [availableApps, setAvailableApps] = useState(null);
	const [error, setError] = useState(null);
	const [form, setForm] = useState({
		name: "",
		reason: "",
	});
	const handleNameChange = ({ target }) => {
		setForm((prev) => ({ ...prev, name: target.value }));
		setError(null);
	};
	const handleReasonChange = ({ target }) => {
		setForm((prev) => ({ ...prev, reason: target.value }));
		setError(null);
	};
	useEffect(() => {
		if (selectedDate !== null) {
			axios
				.get(`${API_BASE}getAppointments`, {
					params: { date: submitedDateFormat(selectedDate) },
				})
				.then((response) => {
					setAvailableApps(
						APP_TIMES.filter(
							(el) => !response.data.map((element) => element.time).includes(el)
						)
					);
				});
		} else {
			setAvailableApps(null);
		}
	}, [selectedDate]);
	const submitForm = () => {
		if (form.name && form.reason) {
			const fd = new FormData();
			fd.append("name", form.name);
			fd.append("date", submitedDateFormat(selectedDate));
			fd.append("time", selectedTime);
			fd.append("reason", form.reason);
			axios
				.post(`${API_BASE}createAppointment`, fd, {
					"Content-Type": "multipart/form-data",
				})
				.then(({ data }) => {
					window.location = data.redirect;
				})
				.catch((res) => {
					setError(
						"This appointment just got reserved! Please chose a different time or date."
					);
				});
		} else {
			setError("All fields are required");
		}
	};
	return (
		<>
			{/* remove the container class before compiling  */}
			<div className="flex justify-center gap-20">
				<div className="w-[50%] ">
					<Calendar
						// value={null}
						className="m-auto mt-10 scalex-110"
						minDetail="month"
						locale="EN-en"
						minDate={
							new Date().getHours() <= 2
								? new Date()
								: new Date(Date.now() + 86400000)
						}
						onClickDay={(value) => {
							if (["Saturday", "Sunday"].includes(days[value.getDay()])) {
								setSelectedDate(null);
							} else {
								setSelectedDate(value);
							}
							setSelectedTime("");
						}}
					/>
				</div>
				<div className="w-[50%]">
					{error && <p className="text-red-700">{error}</p>}
					{!selectedDate ? (
						<p>Select a date to view available appointments</p>
					) : (
						<div className="flex flex-col">
							<p>Date selected : {formatDate(selectedDate)}</p>
							<p>Select a time for your appointment from the list below</p>
							{typeof selectedTime === "string" ? (
								<select
									value={selectedTime}
									className="input"
									onChange={({ target }) => {
										setSelectedTime(target.value);
										setError(null);
									}}
								>
									<option value="">--:--</option>
									{availableApps?.map((el, i) => (
										<option key={i} value={el}>
											{el}
										</option>
									))}
								</select>
							) : (
								""
							)}
							<label htmlFor="">Patient name</label>
							<input
								type="text"
								className="input"
								onChange={handleNameChange}
								value={form.name}
							/>
							<label htmlFor="">Appointment reason</label>
							<textarea
								onChange={handleReasonChange}
								className="resize-none input h-24"
								value={form.reason}
							></textarea>
							<button className="btn-default" onClick={submitForm}>
								Book Appointment
							</button>
						</div>
					)}
				</div>
			</div>
		</>
	);
}

export default App;
