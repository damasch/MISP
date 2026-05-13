module.exports = {
  content: [
    "./app/View/**/*.ctp",     // alle .ctp Dateien
    "./webroot/**/*.js",     // falls du JS nutzt
  ],
  theme: {
    extend: {
      colors: {
        misp: {
          blue: "var(--color-mispblue)",
          darkblue: "var(--color-mispdarkblue)",
          night: "var(--color-mispnight)",
          accent: "var(--color-mispaccentnight)",

          // neue Farben fürs Dashboard
          border: "#1e3a52",
          card: "#0f1624",
          background: "#0a0e1a",

          cyan: "#22d3ee",
          sky: "#38bdf8",
          emerald: "#34d399",
          amber: "#fbbf24",
          red: "#f87171",

          muted: "#94a3b8"
        }
      },
    },
  },
  plugins: [],
}
