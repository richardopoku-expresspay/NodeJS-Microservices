'use strict'

module.exports.up = (queryInterface, DataTypes) => {
    return queryInterface.createTable("useSessions", {
        id: {
            allowNull: false,
            primaryKey: true,
            type: DataTypes.UUID,
        },
        userId: {
            allowNull: false,
            references: {
                key: "id",
                model: "users",
            },
            type: DataTypes.UUID,
        },
        expiresAt: {
            allowNull: false,
            type: DataTypes.DATE,
        },
        createdAt: {
            allowNull: false,
            type: DataTypes.DATE,
        }
    }, {
        charset: "utf8"
    });
};

module.exports.down = (queryInterface, DataTypes) => {
    return queryInterface.dropTable('useSessions');
}