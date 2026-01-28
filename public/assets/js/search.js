document.addEventListener("DOMContentLoaded", () => {
  console.log("Live search loaded");

  const input = document.getElementById("search");
  const table = document.querySelector("table");

  if (!input || !table) return;

  const rows = table.querySelectorAll("tr");

  input.addEventListener("keyup", () => {
    const keyword = input.value.toLowerCase().trim();

    rows.forEach((row, index) => {
      if (index === 0) return; // skip header

      const name = row.cells[0].textContent.toLowerCase();
      const category = row.cells[1].textContent.toLowerCase();
      const price = row.cells[2].textContent.replace("$", "").toLowerCase(); // remove $ for numeric match
      const stock = row.cells[3].textContent.toLowerCase();

      // Show row if any column matches keyword
      if (
        name.includes(keyword) ||
        category.includes(keyword) ||
        price.includes(keyword) ||
        stock.includes(keyword)
      ) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});

