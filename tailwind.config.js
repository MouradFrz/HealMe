/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./src/Views/*.php",
		"./src/Views/admin/*.php",
		"./src/Views/components/*.php",
		"./public/app/src/**/*.{js,jsx,ts,tsx}",
	],
	theme: {
		extend: {},
	},
	plugins: [],
};
