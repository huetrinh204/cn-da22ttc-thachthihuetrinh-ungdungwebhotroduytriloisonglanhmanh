async function loadHabits() {
  const res = await fetch("../api/get_habits.php");
  const habits = await res.json();
  const container = document.getElementById("habitList");

  container.innerHTML = "";
  habits.forEach((habit) => {
    const div = document.createElement("div");
    div.className = "habit";
    div.innerHTML = `
      <input type="checkbox" id="habit-${habit.habit_id}" ${habit.status == 1 ? "checked" : ""}>
      <label for="habit-${habit.habit_id}">
        ${habit.icon || "🐾"} ${habit.habit_name}
      </label>
    `;
    container.appendChild(div);

    div.querySelector("input").addEventListener("change", async (e) => {
      const checked = e.target.checked ? 1 : 0;
      await fetch("../api/update_habit.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${habit.habit_id}&is_completed=${checked}`,
      });
      updateStats();
    });
  });

  updateStats();
}

async function updateStats() {
  const res = await fetch("../api/get_stats.php");
  const stats = await res.json();

  document.getElementById("totalHabits").textContent = stats.total;
  document.getElementById("completedToday").textContent =
    `${stats.completed}/${stats.total} (${stats.percent}%)`;
  document.getElementById("streakDays").textContent = stats.streak;
}

loadHabits();
