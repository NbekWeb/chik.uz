// tailwind.config.js

module.exports = {
    content: ["./index.html", "./resources/js/**/*.{vue,js,ts,jsx,tsx}"],
    theme: {
      extend: {
        colors: {
          green: '#04b70a;',
          light__black: '#111',
          muted: '#9BA2B1'
        },
        // fontFamily: {
        //   IBM: ["IBM", "sans"],
        //   Viaoda: ["Viaoda", "sans"],
        // },
      },
    },
    plugins: [],
  };