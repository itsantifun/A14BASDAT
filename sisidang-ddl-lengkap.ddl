create table MAHASISWA(
	npm char(10) primary key,
	nama varchar(100) not null,
	username varchar(30) not null,
	password varchar(20) not null,
	email varchar(100) not null,
	email_alternatif varchar(100),
	telepon varchar(100),
	notelp varchar(100)
);

create table TERM(
	tahun integer,
	semester integer,
	primary key (tahun, semester),
	unique (tahun, semester)
);

create table PRODI(
	id integer primary key,
	namaprodi varchar(50) not null unique
);

create table DOSEN(
	nip varchar(20) primary key,
	nama varchar(100) not null,
	username varchar(50) not null,
	password varchar(50) not null,
	email varchar(100) not null,
	institusi varchar(100) not null
);

create table MATA_KULIAH_SPESIAL(
	idmks serial not null unique,
	npm char(10) references mahasiswa(npm),
	tahun integer,
	semester integer,
	judul Varchar(250) not null,
	issiapsidang boolean default FALSE,
	pengumpulanhardcopy boolean default FALSE,
	ijinmajusidang boolean default FALSE,
	idjenismks integer not null,
	primary key (idmks, npm, Tahun, Semester),
	foreign key (tahun, semester) references TERM (tahun, semester)
);

create table JENISMKS(
	id integer primary key,
	namamks varchar(50) not null unique
);

create table DOSEN_PEMBIMBING(
	idmks integer references MATA_KULIAH_SPESIAL (idmks),
	nipdosenpembimbing varchar(20) references DOSEN (nip),
	primary key (idmks, nipdosenpembimbing)
	);

CREATE TABLE SARAN_DOSEN_PENGUJI(
	IDMKS INT REFERENCES MATA_KULIAH_SPESIAL(IDMKS),
	NIPsaranpenguji VARCHAR(20) REFERENCES DOSEN(NIP),
	PRIMARY KEY(IDMKS,NIPsaranpenguji)
);

CREATE TABLE DOSEN_PENGUJI(
	IDMKS INT REFERENCES MATA_KULIAH_SPESIAL(IDMKS),
	NIPdosenpenguji VARCHAR(20) REFERENCES DOSEN(NIP),
	PRIMARY KEY(IDMKS,NIPdosenpenguji)	
);

CREATE TABLE TIMELINE(
	IdTimeline INT PRIMARY KEY,
	NamaEvent VARCHAR(100) NOT NULL,
	Tanggal DATE NOT NULL ,
	Tahun INT NOT NULL,
	Semester INT NOT NULL,
	foreign key (tahun, semester) references TERM (tahun, semester)
);

CREATE TABLE JADWAL_NON_SIDANG(
	IdJadwal INT PRIMARY KEY,
	Tanggalmulai DATE NOT NULL,
	Tanggalselesai DATE NOT NULL,
	Alasan VARCHAR(100) NOT NULL,
	Repetisi VARCHAR(50),
	NIPdosen VARCHAR(10) NOT NULL REFERENCES DOSEN(NIP)
);

CREATE TABLE RUANGAN(
	IdRuangan INT PRIMARY KEY,
	NamaRuangan VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE JADWAL_SIDANG(
	IdJadwal INT,
	IDMKS INT REFERENCES MATA_KULIAH_SPESIAL(IDMKS),
	Tanggal DATE NOT NULL,
	JamMulai TIME NOT NULL,
	JamSelesai TIME NOT NULL,
	IdRuangan INT NOT NULL REFERENCES RUANGAN(IdRuangan),
	PRIMARY KEY(IdJadwal, IDMKS)
);

CREATE TABLE BERKAS(
	IdBerkas INT,
	IDMKS INT REFERENCES MATA_KULIAH_SPESIAL(IDMKS),
	Nama VARCHAR(100) NOT NULL,
	Alamat VARCHAR(100) NOT NULL,
	PRIMARY KEY(IdBerkas, IDMKS)
);
