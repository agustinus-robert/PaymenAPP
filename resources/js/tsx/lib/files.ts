import fs from "fs";

function getPath(path: string): string {
  return path;
}
export function writeFile(fileName: string, data: string) {
  fs.writeFileSync(getPath(fileName), data);
}

export function readFile(fileName: string): string {
  return fs.readFileSync(getPath(fileName), "utf-8");
}

export function existsFile(path: string): boolean {
  return fs.existsSync(getPath(path));
}
