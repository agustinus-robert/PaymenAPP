import { EditorPage } from "@brizy/builder";

export type Item = {
  id: string;
  title: string;
  slug: {
    collection: string;
    item: string;
  };
  createdAt?: string;
  data: EditorPage["data"];
  status: EditorPage["status"];
  dataVersion: EditorPage["dataVersion"];
};
