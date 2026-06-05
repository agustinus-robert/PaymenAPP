export interface Seo {
  title: string;
  description: string;
  searchVisibility: boolean;
}

export interface Sharing {
  title: string;
  description: string;
  preserveSeoTitle: boolean;
  preserveSeoDescription: boolean;
}

export interface Code {
  customCss: string;
  codeInjectionFooter: string;
  codeInjectionHeader: string;
}

export interface ProjectSettings {
  seo: Seo;
  sharing: Sharing;
  code: Code;
}
