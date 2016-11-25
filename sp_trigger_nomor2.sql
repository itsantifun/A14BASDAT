CREATE TRIGGER cek_tanggal_JNS
BEFORE INSERT
ON JADWAL_NON_SIDANG
FOR EACH ROW
EXECUTE PROCEDURE cek_tanggal();

CREATE TRIGGER cek_tanggal_ijinmaju
BEFORE UPDATE
ON MATA_KULIAH_SPESIAL
FOR EACH ROW
EXECUTE PROCEDURE cek_tanggal();

CREATE OR REPLACE FUNCTION cek_tanggal()
RETURNS "trigger" AS
$$
	DECLARE tanggal_bikin_sekarang DATE;
	DECLARE tanggal_deadline DATE;
	BEGIN
		tanggal_bikin_sekarang = current_date;

		IF(TG_TABLE_NAME = 'jadwal_non_sidang') THEN
			SELECT tanggal INTO tanggal_deadline
			FROM TIMELINE
			WHERE namaEvent LIKE '%jadwal%dosen%' AND date_part('year',tanggal_bikin_sekarang) = Tahun;
			
			IF tanggal_bikin_sekarang > tanggal_deadline THEN
				RAISE EXCEPTION 'sudah lewat deadline keles';
			END IF;

			RETURN NEW;
		
		ELSIF(TG_TABLE_NAME = 'mata_kuliah_spesial') THEN
			SELECT tanggal INTO tanggal_deadline
			FROM TIMELINE
			WHERE namaEvent LIKE '%izin%maju%Sidang%' AND date_part('year',tanggal_bikin_sekarang) = Tahun;
			
			IF tanggal_bikin_sekarang > tanggal_deadline THEN
				IF NEW.ijinmajusidang IS TRUE THEN
					RAISE EXCEPTION 'sudah lewat deadline keles';
				END IF;
			END IF;

			RETURN NEW;

		END IF;
		
	END;
$$
LANGUAGE 'plpgsql' VOLATILE;

--kebutuhan testing
insert into JADWAL_NON_SIDANG values(1,'11-11-2106','11-14-2016','sibuk banget', '', '01000001');

delete from JADWAL_NON_SIDANG where idjadwal = 1;

update timeline set tanggal = '11-24-2016' where idtimeline = 1;

update timeline set tanggal = '11-27-2016' where idtimeline = 1;

update mata_kuliah_spesial set ijinmajusidang = 'true';

update mata_kuliah_spesial set ijinmajusidang = 'false';

update timeline set tanggal = '11-24-2016' where idtimeline = 2;

update timeline set tanggal = '11-27-2016' where idtimeline = 2;

update timeline set namaEvent = 'Pemberian izin maju Sidang oleh pembimbing' where idtimeline = 2;

--disclaimer
/*
insert ke timeline Pemberian izin maju Sidang oleh pembimbing dan Pengisian jadwal pribadi oleh dosen
persis yak jangan beda gede kecil nya nanti gabisa. ty. :) 
*/
