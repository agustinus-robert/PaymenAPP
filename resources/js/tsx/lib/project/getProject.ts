import type { EditorProject } from "@brizy/builder";
import { existsFile, readFile } from "@/lib/files";

// Replace with call to your database
export const getProject = (): EditorProject | undefined => {
  const allData: EditorProject | null = existsFile("project.database.json")
    ? JSON.parse(readFile("project.database.json"))
    : null;

  return allData ?? undefined;
};
