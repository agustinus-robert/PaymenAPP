import type { EditorProject } from "@brizy/builder";
import { writeFile } from "@/lib/files";

export const updateProject = (projectData: EditorProject | null) => {
  if (!projectData) {
    return;
  }

  writeFile("project.database.json", JSON.stringify(projectData));
};
