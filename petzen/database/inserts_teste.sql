INSERT INTO clientes (nome, email, telefone, endereco, pet) VALUES
('Ana Souza', 'ana@example.com', '(11) 99999-1111', 'Rua das Flores, 45', 'Bolinha'),
('Carlos Lima', 'carlos@example.com', '(11) 98888-2222', 'Av. Paulista, 1020', 'Rex'),
('Julia Fernandes', 'julia@example.com', '(11) 97777-3333', 'Rua Verde, 123', 'Mimi');

INSERT INTO agendamentos (data_hora, servico, status, observacoes, id_cliente) VALUES
('2025-10-30 10:00:00', 'Banho e Tosa', 'Concluído', 'Cliente retornará em 15 dias', 1),
('2025-10-31 14:30:00', 'Consulta Veterinária', 'Pendente', 'Primeira consulta', 2),
('2025-11-01 09:00:00', 'Vacinação', 'Pendente', 'Aplicar vacina V10', 3);