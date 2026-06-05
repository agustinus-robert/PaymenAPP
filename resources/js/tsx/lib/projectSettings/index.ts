import { existsFile, readFile, writeFile } from "@/lib/files";
import { ProjectSettings } from "./types";

export const getProjectSettings = (): ProjectSettings | null => {
  const setting = existsFile("dashboard.database.json") ? JSON.parse(readFile("dashboard.database.json")) : null;

  return setting?.projectSettings || null;
};

export const updateProjectSettings = (settings: ProjectSettings) => {
  return writeFile("dashboard.database.json", JSON.stringify({ projectSettings: settings }));
};
