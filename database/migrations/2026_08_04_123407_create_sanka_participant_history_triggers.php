<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * 履歴保存トリガーを作成する
     */
    public function up(): void
    {
        // 新規登録時
        DB::unprepared('
            CREATE TRIGGER trg_sanka_participants_insert
            AFTER INSERT ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    participant_id,
                    reception_serial,
                    reception_number,
                    operation,
                    family_name,
                    first_name,
                    family_name_kana,
                    first_name_kana,
                    organization,
                    department,
                    laboratory,
                    address_type_id,
                    postal_code,
                    address,
                    telephone,
                    fax,
                    email,
                    expertise_ids,
                    expertise_other,
                    society_ids,
                    society_other,
                    join_type_id,
                    travel_support_requested,
                    banquet_requested,
                    participation_fee,
                    banquet_fee,
                    total_amount,
                    remarks,
                    admin_remarks,
                    mail_sent,
                    is_selector,
                    status,
                    participant_created_at,
                    participant_updated_at,
                    participant_deleted_at,
                    operated_at
                ) VALUES (
                    NEW.id,
                    NEW.reception_serial,
                    NEW.reception_number,
                    "INSERT",
                    NEW.family_name,
                    NEW.first_name,
                    NEW.family_name_kana,
                    NEW.first_name_kana,
                    NEW.organization,
                    NEW.department,
                    NEW.laboratory,
                    NEW.address_type_id,
                    NEW.postal_code,
                    NEW.address,
                    NEW.telephone,
                    NEW.fax,
                    NEW.email,
                    NEW.expertise_ids,
                    NEW.expertise_other,
                    NEW.society_ids,
                    NEW.society_other,
                    NEW.join_type_id,
                    NEW.travel_support_requested,
                    NEW.banquet_requested,
                    NEW.participation_fee,
                    NEW.banquet_fee,
                    NEW.total_amount,
                    NEW.remarks,
                    NEW.admin_remarks,
                    NEW.mail_sent,
                    NEW.is_selector,
                    NEW.status,
                    NEW.created_at,
                    NEW.updated_at,
                    NEW.deleted_at,
                    NOW()
                );
            END
        ');

        // 更新時
        DB::unprepared('
            CREATE TRIGGER trg_sanka_participants_update
            AFTER UPDATE ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    participant_id,
                    reception_serial,
                    reception_number,
                    operation,
                    family_name,
                    first_name,
                    family_name_kana,
                    first_name_kana,
                    organization,
                    department,
                    laboratory,
                    address_type_id,
                    postal_code,
                    address,
                    telephone,
                    fax,
                    email,
                    expertise_ids,
                    expertise_other,
                    society_ids,
                    society_other,
                    join_type_id,
                    travel_support_requested,
                    banquet_requested,
                    participation_fee,
                    banquet_fee,
                    total_amount,
                    remarks,
                    admin_remarks,
                    mail_sent,
                    is_selector,
                    status,
                    participant_created_at,
                    participant_updated_at,
                    participant_deleted_at,
                    operated_at
                ) VALUES (
                    NEW.id,
                    NEW.reception_serial,
                    NEW.reception_number,
                    CASE
                        WHEN OLD.deleted_at IS NULL
                            AND NEW.deleted_at IS NOT NULL
                        THEN "DELETE"
                        ELSE "UPDATE"
                    END,
                    NEW.family_name,
                    NEW.first_name,
                    NEW.family_name_kana,
                    NEW.first_name_kana,
                    NEW.organization,
                    NEW.department,
                    NEW.laboratory,
                    NEW.address_type_id,
                    NEW.postal_code,
                    NEW.address,
                    NEW.telephone,
                    NEW.fax,
                    NEW.email,
                    NEW.expertise_ids,
                    NEW.expertise_other,
                    NEW.society_ids,
                    NEW.society_other,
                    NEW.join_type_id,
                    NEW.travel_support_requested,
                    NEW.banquet_requested,
                    NEW.participation_fee,
                    NEW.banquet_fee,
                    NEW.total_amount,
                    NEW.remarks,
                    NEW.admin_remarks,
                    NEW.mail_sent,
                    NEW.is_selector,
                    NEW.status,
                    NEW.created_at,
                    NEW.updated_at,
                    NEW.deleted_at,
                    NOW()
                );
            END
        ');

        // 物理削除時
        DB::unprepared('
            CREATE TRIGGER trg_sanka_participants_delete
            AFTER DELETE ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    participant_id,
                    reception_serial,
                    reception_number,
                    operation,
                    family_name,
                    first_name,
                    family_name_kana,
                    first_name_kana,
                    organization,
                    department,
                    laboratory,
                    address_type_id,
                    postal_code,
                    address,
                    telephone,
                    fax,
                    email,
                    expertise_ids,
                    expertise_other,
                    society_ids,
                    society_other,
                    join_type_id,
                    travel_support_requested,
                    banquet_requested,
                    participation_fee,
                    banquet_fee,
                    total_amount,
                    remarks,
                    admin_remarks,
                    mail_sent,
                    is_selector,
                    status,
                    participant_created_at,
                    participant_updated_at,
                    participant_deleted_at,
                    operated_at
                ) VALUES (
                    OLD.id,
                    OLD.reception_serial,
                    OLD.reception_number,
                    "HARD_DELETE",
                    OLD.family_name,
                    OLD.first_name,
                    OLD.family_name_kana,
                    OLD.first_name_kana,
                    OLD.organization,
                    OLD.department,
                    OLD.laboratory,
                    OLD.address_type_id,
                    OLD.postal_code,
                    OLD.address,
                    OLD.telephone,
                    OLD.fax,
                    OLD.email,
                    OLD.expertise_ids,
                    OLD.expertise_other,
                    OLD.society_ids,
                    OLD.society_other,
                    OLD.join_type_id,
                    OLD.travel_support_requested,
                    OLD.banquet_requested,
                    OLD.participation_fee,
                    OLD.banquet_fee,
                    OLD.total_amount,
                    OLD.remarks,
                    OLD.admin_remarks,
                    OLD.mail_sent,
                    OLD.is_selector,
                    OLD.status,
                    OLD.created_at,
                    OLD.updated_at,
                    OLD.deleted_at,
                    NOW()
                );
            END
        ');
    }

    /**
     * 履歴保存トリガーを削除する
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_delete');
    }
};
