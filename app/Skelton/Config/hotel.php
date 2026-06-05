<?php

return [

	'name' => 'Human Resource Management System - ' . config('app.name'),

	'features' => [
		'benefit' => [
			'insurance' => [
				'maxSalary' => 12000000,
				'minSalary' => 2725547,
				'kesLimit'  => 4000000,
				'tkMaxSalary' => null,
				'tkMinSalary' => 2725547,
				'tkPensiunMaxSalary' => 10547000,
				'bpjs' => [
					'kesehatan' => [
						'Kelas 1' => [
							[
								'value' => 'kelas-1',
								'label' => 'Kelas 1',
								'items' => [
									['category' => 1, 'meta' => ['group' => 'Kelas 1', 'membership' => 'Penerima Upah']],
								],
							],
							[
								'value' => 'kelas-1-3tk',
								'label' => 'Kelas 1 + 3TK',
								'items' => [
									['category' => 1, 'meta' => ['group' => 'Kelas 1', 'membership' => 'Penerima Upah']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Hari Tua']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kecelakaan']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kematian']],
								],
							],
							[
								'value' => 'kelas-1-3tk-pensiun',
								'label' => 'Kelas 1 + 3TK + TK Pensiun',
								'items' => [
									['category' => 1, 'meta' => ['group' => 'Kelas 1', 'membership' => 'Penerima Upah']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Hari Tua']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kecelakaan']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kematian']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Pensiun']],
								],
							],
						],
						'Kelas 2' => [
							[
								'value' => 'kelas-2',
								'label' => 'Kelas 2',
								'items' => [
									['category' => 1, 'meta' => ['group' => 'Kelas 2', 'membership' => 'Penerima Upah']],
								],
							],
							[
								'value' => 'kelas-2-3tk',
								'label' => 'Kelas 2 + 3TK',
								'items' => [
									['category' => 1, 'meta' => ['group' => 'Kelas 2', 'membership' => 'Penerima Upah']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Hari Tua']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kecelakaan']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kematian']],
								],
							],
							[
								'value' => 'kelas-2-3tk-pensiun',
								'label' => 'Kelas 2 + 3TK + TK Pensiun',
								'items' => [
									['category' => 1, 'meta' => ['group' => 'Kelas 2', 'membership' => 'Penerima Upah']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Hari Tua']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kecelakaan']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Kematian']],
									['category' => 2, 'meta' => ['services' => 'Jaminan Pensiun']],
								],
							],
						],
					],
					'ketenagakerjaan' => [
						[
							'value' => '3tk',
							'label' => '3TK',
							'items' => [
								['category' => 2, 'meta' => ['services' => 'Jaminan Hari Tua']],
								['category' => 2, 'meta' => ['services' => 'Jaminan Kecelakaan']],
								['category' => 2, 'meta' => ['services' => 'Jaminan Kematian']],
							],
						],
						[
							'value' => '3tk-pensiun',
							'label' => '3TK + Pensiun',
							'items' => [
								['category' => 2, 'meta' => ['services' => 'Jaminan Hari Tua']],
								['category' => 2, 'meta' => ['services' => 'Jaminan Kecelakaan']],
								['category' => 2, 'meta' => ['services' => 'Jaminan Kematian']],
								['category' => 2, 'meta' => ['services' => 'Jaminan Pensiun']],
							],
						],
					],
				]
			],
		],
	],

];
