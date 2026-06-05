import { existsFile, readFile, writeFile } from "@/lib/files";
import { Item } from "./types";

export const readPagesDataBase = (): Item[] => {
  const isFileExist = existsFile("pages.database.json");

  if (!isFileExist) {
    writeFile("pages.database.json", "[]");
  }

  const items = JSON.parse(readFile("pages.database.json"));

  if (!Array.isArray(items)) {
    writeFile("pages.database.json", "[]");
    return [];
  }

  return items;
};

export const addPageToDataBase = (page: Item) => {
  const pages = readPagesDataBase();
  pages.push(page);

  writeFile("pages.database.json", JSON.stringify(pages, null, 2));
};

export const updatePageInDataBase = (page: Partial<Item>) => {
  const pages = readPagesDataBase();
  const pageIndex = pages.findIndex((p) => p.id === page.id);

  if (pageIndex === -1) {
    throw new Error("Page not found");
  }

  pages[pageIndex] = {
    ...pages[pageIndex],
    ...page.data,
  };

  writeFile("pages.database.json", JSON.stringify(pages, null, 2));

  return pages[pageIndex];
};

export const deletePageFromDataBase = (id: string) => {
  const pages = readPagesDataBase();
  const pageIndex = pages.findIndex((p) => p.id === id);

  if (pageIndex === -1) {
    throw new Error("Page not found");
  }

  const page = pages[pageIndex];

  pages.splice(pageIndex, 1);

  writeFile("pages.database.json", JSON.stringify(pages, null, 2));

  return page;
};

export const getPageFromDataBase = (id: string) => {
  const pages = readPagesDataBase();
  const page = pages.find((p) => p.id === id);

  if (!page) {
    throw new Error("Page not found");
  }

  return page;
};
