import type { EditorPage } from "@brizy/builder";
import { readPagesDataBase } from "@/lib/item/utils";

export const getPage = (collection: string, slug: string): EditorPage | undefined => {
  const pages = readPagesDataBase();

  return pages.find((page) => page.slug.collection === collection && page.slug.item === slug);
};
